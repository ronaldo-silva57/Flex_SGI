<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CipaReuniao;
use App\Models\Epi;
use App\Models\EpiUsuario;
use App\Models\ExameMedico;
use App\Models\IncidenteAcidente;
use App\Models\PerigoRisco;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsISO45001Controller extends Controller
{
    public function index()
    {
        $hoje   = Carbon::today();
        $em30   = Carbon::today()->addDays(30);
        $em60   = Carbon::today()->addDays(60);
        $iniAno = Carbon::today()->startOfYear();

        // ---------- Dias sem acidente ----------
        $ultimoAcidente = IncidenteAcidente::whereIn('tipo', ['Acidente leve', 'Acidente grave', 'Fatal'])
            ->orderByDesc('data_ocorrencia')
            ->first();

        $diasSemAcidente = $ultimoAcidente
            ? Carbon::parse($ultimoAcidente->data_ocorrencia)->diffInDays($hoje)
            : null;

        // ---------- KPIs principais ----------
        $kpis = [
            'dias_sem_acidente'   => $diasSemAcidente,
            'perigos_ativos'      => PerigoRisco::where('status', 'Ativo')->count(),
            'perigos_alto_risco'  => PerigoRisco::where('status', 'Ativo')
                                        ->where('nivel_risco', '>=', 15)->count(),
            'incidentes_ano'      => IncidenteAcidente::where('data_ocorrencia', '>=', $iniAno)->count(),
            'dias_perdidos_ano'   => (int) IncidenteAcidente::where('data_ocorrencia', '>=', $iniAno)
                                        ->sum('dias_perdidos'),
        ];

        // ---------- Alertas ----------
        $alertas = [
            'incidentes_abertos' => IncidenteAcidente::whereIn('status', ['Aberto', 'Em investigação'])->count(),

            'perigos_sem_controle' => PerigoRisco::where('status', 'Ativo')
                ->where('necessita_acao', true)
                ->where(function ($q) {
                    $q->whereNull('medida_controle')->orWhere('medida_controle', '');
                })->count(),

            'epis_estoque_baixo' => Epi::where('ativo', true)
                ->whereColumn('estoque_atual', '<', 'estoque_minimo')->count(),

            'epis_vencidos' => EpiUsuario::where('status', 'Ativo')
                ->whereNotNull('data_vencimento')
                ->whereDate('data_vencimento', '<', $hoje)->count(),

            'epis_vencendo_30d' => EpiUsuario::where('status', 'Ativo')
                ->whereBetween('data_vencimento', [$hoje, $em30])->count(),

            'aso_vencidos' => ExameMedico::where('status', 'Vigente')
                ->whereNotNull('data_vencimento')
                ->whereDate('data_vencimento', '<', $hoje)->count(),

            'aso_vencendo_60d' => ExameMedico::where('status', 'Vigente')
                ->whereBetween('data_vencimento', [$hoje, $em60])->count(),

            'cipa_pendentes' => CipaReuniao::where('status', 'Agendada')
                ->whereDate('data_reuniao', '<', $hoje)->count(),
        ];

        // ---------- Gráfico: Incidentes por tipo (12 meses) ----------
        $incidentesPorTipo = IncidenteAcidente::where('data_ocorrencia', '>=', $hoje->copy()->subMonths(12))
            ->select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')->pluck('total', 'tipo');

        // ---------- Gráfico: Incidentes por mês (12 meses) ----------
        $incidentesMes = IncidenteAcidente::select(
                DB::raw("TO_CHAR(data_ocorrencia, 'YYYY-MM') as mes"),
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(dias_perdidos) as dias_perdidos")
            )
            ->where('data_ocorrencia', '>=', $hoje->copy()->subMonths(12))
            ->groupBy('mes')->orderBy('mes')->get();

        // ---------- Gráfico: Perigos por nível de risco ----------
        $perigosPorNivel = PerigoRisco::where('status', 'Ativo')
            ->select('nivel_risco', DB::raw('COUNT(*) as total'))
            ->whereNotNull('nivel_risco')
            ->groupBy('nivel_risco')->orderBy('nivel_risco')
            ->pluck('total', 'nivel_risco');

        // ---------- Matriz de risco (scatter) ----------
        $matrizRisco = PerigoRisco::where('status', 'Ativo')
            ->whereNotNull('probabilidade')->whereNotNull('severidade')
            ->select('probabilidade', 'severidade', DB::raw('COUNT(*) as total'))
            ->groupBy('probabilidade', 'severidade')
            ->get();

        // ---------- Gráfico: Exames por tipo ASO ----------
        $examesPorTipo = ExameMedico::where('status', 'Vigente')
            ->select('tipo_aso', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo_aso')->pluck('total', 'tipo_aso');

        // ---------- Gráfico: CIPA por status ----------
        $cipaPorStatus = CipaReuniao::whereYear('data_reuniao', $hoje->year)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        // ---------- Listas acionáveis ----------
        $incidentesRecentes = IncidenteAcidente::with('usuario')
            ->orderByDesc('data_ocorrencia')->limit(5)
            ->get(['id', 'usuario_id', 'tipo', 'local', 'data_ocorrencia', 'status', 'dias_perdidos']);

        $perigosCriticos = PerigoRisco::where('status', 'Ativo')
            ->where('nivel_risco', '>=', 15)
            ->orderByDesc('nivel_risco')->limit(5)
            ->get(['id', 'descricao_perigo', 'risco_associado', 'nivel_risco', 'necessita_acao']);

        $proximosAsos = ExameMedico::with('usuario')
            ->where('status', 'Vigente')
            ->whereBetween('data_vencimento', [$hoje, $em60])
            ->orderBy('data_vencimento')->limit(5)
            ->get(['id', 'usuario_id', 'tipo_aso', 'data_vencimento']);

        $episCriticos = Epi::where('ativo', true)
            ->whereColumn('estoque_atual', '<', 'estoque_minimo')
            ->orderByRaw('(estoque_minimo - estoque_atual) DESC')
            ->limit(5)
            ->get(['id', 'nome', 'estoque_atual', 'estoque_minimo']);

        $proximaCipa = CipaReuniao::where('status', 'Agendada')
            ->whereDate('data_reuniao', '>=', $hoje)
            ->orderBy('data_reuniao')->first();

        return view('iso45001.analytics', compact(
            'kpis', 'alertas',
            'incidentesPorTipo', 'incidentesMes', 'perigosPorNivel', 'matrizRisco',
            'examesPorTipo', 'cipaPorStatus',
            'incidentesRecentes', 'perigosCriticos', 'proximosAsos', 'episCriticos', 'proximaCipa',
            'diasSemAcidente', 'ultimoAcidente'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Calibracao;
use App\Models\EquipamentoMedicao;
use App\Models\Indicador;
use App\Models\Monitoramento;
use App\Models\Norma;
use App\Models\PesquisaSatisfacao;
use App\Models\PesquisaSatisfacaoResposta;
use App\Models\Processo;
use App\Models\ReuniaoGestao;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $hoje     = Carbon::today();
        $em30Dias = Carbon::today()->addDays(30);

        /**
         * ========== KPIS principais =========
         */
        $kpis = [
            'normas_ativas'         => Norma::where('ativo', true)->count(),
            'processos_ativos'      => Processo::where('ativo', true)->count(),
            'indicadores_ativos'    => Indicador::where('ativo', true)->count(),
            'reunioes_ano'          => ReuniaoGestao::whereYear('data_reuniao', $hoje->year)->count(),
        ];

        // ---------- Alertas ----------
        $alertas = [
            // Calibrações vencidas
            'calibracoes_vencidas' => EquipamentoMedicao::where('status', 'Ativo')
                ->whereDate('proxima_calibracao', '<', $hoje)
                ->count(),

            // Calibrações vencendo em 30 dias
            'calibracoes_proximas' => EquipamentoMedicao::where('status', 'Ativo')
                ->whereBetween('proxima_calibracao', [$hoje, $em30Dias])
                ->count(),

            // Monitoramentos atrasados
            'monitoramentos_atrasados' => Monitoramento::where('status', 'Atrasado')->count(),

            // Indicadores sem monitoramento no período
            'indicadores_sem_monitoramento' => Indicador::where('ativo', true)
                ->whereDoesntHave('monitoramentos', function ($q) use ($hoje) {
                    $q->where('created_at', '>=', $hoje->copy()->subDays(60));
                })->count(),

            // Pesquisas de satisfação em andamento
            'pesquisas_andamento' => PesquisaSatisfacao::where('status', 'Em andamento')->count(),
        ];

        // ---------- NPS consolidado ----------
        $nps = $this->calcularNps();

        // ---------- Gráfico: monitoramentos por mês (últimos 12) ----------
        $monitoramentosMes = Monitoramento::select(
                DB::raw("TO_CHAR(created_at, 'YYYY-MM') as mes"),
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status = 'Atrasado' THEN 1 ELSE 0 END) as atrasados")
            )
            ->where('created_at', '>=', $hoje->copy()->subMonths(12))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // ---------- Gráfico: status dos equipamentos ----------
        $equipamentosStatus = EquipamentoMedicao::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // ---------- Gráfico: NPS por pesquisa ----------
        $npsPorPesquisa = PesquisaSatisfacao::withCount('respostas')
            ->whereNotNull('nota_media')
            ->orderByDesc('data_inicio')
            ->limit(6)
            ->get(['id', 'titulo', 'nota_media', 'data_inicio']);

        // ---------- Lista: próximas calibrações ----------
        $proximasCalibracoes = EquipamentoMedicao::where('status', 'Ativo')
            ->whereNotNull('proxima_calibracao')
            ->orderBy('proxima_calibracao')
            ->limit(5)
            ->get(['id', 'codigo', 'nome', 'proxima_calibracao']);

        // ---------- Lista: monitoramentos atrasados ----------
        $monitoramentosAtrasados = Monitoramento::with('indicador')
            ->where('status', 'Atrasado')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // ---------- Última reunião de análise crítica ----------
        $ultimaReuniao = ReuniaoGestao::where('tipo', 'Revisão Direção')
            ->orderByDesc('data_reuniao')
            ->first();

        return view('iso9001.analytics', compact(
            'kpis',
            'alertas',
            'nps',
            'monitoramentosMes',
            'equipamentosStatus',
            'npsPorPesquisa',
            'proximasCalibracoes',
            'monitoramentosAtrasados',
            'ultimaReuniao'
        ));
    }

    private function calcularNps(): array
    {
        $base = PesquisaSatisfacaoResposta::whereNotNull('classificacao')
            ->where('respondido_em', '>=', Carbon::now()->subMonths(12))
            ->select('classificacao', DB::raw('COUNT(*) as total'))
            ->groupBy('classificacao')
            ->pluck('total', 'classificacao');

        $promotores = $base['Promotor'] ?? 0;
        $detratores = $base['Detrator'] ?? 0;
        $total      = $base->sum();

        return [
            'promotores' => $promotores,
            'neutros'    => $base['Neutro'] ?? 0,
            'detratores' => $detratores,
            'total'      => $total,
            'score'      => $total > 0
                ? round((($promotores - $detratores) / $total) * 100, 1)
                : null,
        ];
    }
}
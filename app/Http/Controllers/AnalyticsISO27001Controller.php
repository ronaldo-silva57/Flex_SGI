<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnaliseRiscoTi;
use App\Models\AtivoInformacao;
use App\Models\ControleSeguranca;
use App\Models\IncidenteSeguranca;
use App\Models\SoaControle;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsISO27001Controller extends Controller
{
    public function index()
    {
        $hoje   = Carbon::today();
        $em30   = Carbon::today()->addDays(30);
        $iniAno = Carbon::today()->startOfYear();

        // ---------- SoA ----------
        $soaTotal       = SoaControle::count();
        $soaAplicaveis  = SoaControle::where('aplicavel', true)->count();
        $soaImpl        = SoaControle::where('aplicavel', true)
                            ->where('status_implementacao', 'Implementado')->count();
        $soaEmImpl      = SoaControle::where('aplicavel', true)
                            ->where('status_implementacao', 'Em implementação')->count();
        $soaPct         = $soaAplicaveis > 0 ? round(($soaImpl / $soaAplicaveis) * 100, 1) : 0;

        // ---------- KPIs ----------
        $kpis = [
            'ativos_ativos'      => AtivoInformacao::where('status', 'Ativo')->count(),
            'ativos_confid'      => AtivoInformacao::where('status', 'Ativo')
                                        ->whereIn('classificacao', ['Confidencial', 'Restrito'])->count(),
            'riscos_abertos'     => AnaliseRiscoTi::whereIn('status', ['Identificado', 'Em tratamento'])->count(),
            'riscos_criticos'    => AnaliseRiscoTi::whereIn('status', ['Identificado', 'Em tratamento'])
                                        ->where('nivel_risco_residual', '>=', 15)->count(),
            'soa_pct'            => $soaPct,
        ];

        // ---------- Alertas ----------
        $alertas = [
            'incidentes_abertos' => IncidenteSeguranca::whereIn('status', ['Aberto', 'Em investigação'])->count(),

            'incidentes_ano' => IncidenteSeguranca::where('data_ocorrencia', '>=', $iniAno)->count(),

            'riscos_sem_tratamento' => AnaliseRiscoTi::where('status', 'Identificado')
                ->where(function ($q) {
                    $q->whereNull('plano_tratamento')->orWhere('plano_tratamento', '');
                })->count(),

            'riscos_residual_alto' => AnaliseRiscoTi::where('nivel_risco_residual', '>=', 15)->count(),

            'soa_nao_iniciado' => SoaControle::where('aplicavel', true)
                ->where('status_implementacao', 'Não iniciado')->count(),

            'controles_sem_evidencia' => SoaControle::where('aplicavel', true)
                ->where('status_implementacao', 'Implementado')
                ->whereNull('evidencia_path')->count(),

            'ativos_sem_responsavel' => AtivoInformacao::where('status', 'Ativo')
                ->whereNull('proprietario_id')->count(),

            'ativos_sem_classificacao' => AtivoInformacao::where('status', 'Ativo')
                ->whereNull('classificacao')->count(),
        ];

        // ---------- SoA por domínio (para barra empilhada) ----------
        $soaPorDominio = SoaControle::where('aplicavel', true)
            ->select(
                'dominio',
                DB::raw("SUM(CASE WHEN status_implementacao = 'Implementado' THEN 1 ELSE 0 END) as implementado"),
                DB::raw("SUM(CASE WHEN status_implementacao = 'Em implementação' THEN 1 ELSE 0 END) as em_impl"),
                DB::raw("SUM(CASE WHEN status_implementacao = 'Não iniciado' THEN 1 ELSE 0 END) as nao_iniciado"),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('dominio')
            ->orderBy('dominio')
            ->get();

        // ---------- Ativos por tipo ----------
        $ativosPorTipo = AtivoInformacao::where('status', 'Ativo')
            ->select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')->pluck('total', 'tipo');

        // ---------- Ativos por classificação ----------
        $ativosPorClassificacao = AtivoInformacao::where('status', 'Ativo')
            ->whereNotNull('classificacao')
            ->select('classificacao', DB::raw('COUNT(*) as total'))
            ->groupBy('classificacao')->pluck('total', 'classificacao');

        // ---------- Incidentes por tipo (12 meses) ----------
        $incidentesPorTipo = IncidenteSeguranca::where('data_ocorrencia', '>=', $hoje->copy()->subMonths(12))
            ->select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')->pluck('total', 'tipo');

        // ---------- Incidentes por mês ----------
        $incidentesMes = IncidenteSeguranca::select(
                DB::raw("TO_CHAR(data_ocorrencia, 'YYYY-MM') as mes"),
                DB::raw('COUNT(*) as total')
            )
            ->where('data_ocorrencia', '>=', $hoje->copy()->subMonths(12))
            ->groupBy('mes')->orderBy('mes')->get();

        // ---------- Matriz de risco inerente × residual ----------
        $matrizRisco = AnaliseRiscoTi::whereNotNull('probabilidade')
            ->whereNotNull('impacto')
            ->whereNotNull('probabilidade_residual')
            ->whereNotNull('impacto_residual')
            ->get(['probabilidade', 'impacto', 'probabilidade_residual', 'impacto_residual', 'nivel_risco_inerente', 'nivel_risco_residual']);

        // ---------- Tríade CIA ----------
        $triaCia = [
            'confidencialidade' => AnaliseRiscoTi::where('afeta_confidencialidade', true)->count(),
            'integridade'       => AnaliseRiscoTi::where('afeta_integridade', true)->count(),
            'disponibilidade'   => AnaliseRiscoTi::where('afeta_disponibilidade', true)->count(),
        ];

        // ---------- Listas acionáveis ----------
        $incidentesRecentes = IncidenteSeguranca::with(['ativo', 'responsavel'])
            ->orderByDesc('data_ocorrencia')->limit(5)
            ->get(['id', 'ativo_id', 'responsavel_id', 'tipo', 'data_ocorrencia', 'status']);

        $riscosCriticos = AnaliseRiscoTi::with('ativo')
            ->whereIn('status', ['Identificado', 'Em tratamento'])
            ->where('nivel_risco_residual', '>=', 12)
            ->orderByDesc('nivel_risco_residual')->limit(5)
            ->get(['id', 'ativo_id', 'ameaca', 'nivel_risco_inerente', 'nivel_risco_residual', 'status', 'opcao_tratamento']);

        $dominiosPendentes = SoaControle::where('aplicavel', true)
            ->whereIn('status_implementacao', ['Não iniciado', 'Em implementação'])
            ->select('dominio',
                DB::raw("SUM(CASE WHEN status_implementacao = 'Não iniciado' THEN 1 ELSE 0 END) as nao_ini"),
                DB::raw("SUM(CASE WHEN status_implementacao = 'Em implementação' THEN 1 ELSE 0 END) as em_impl"),
                DB::raw('COUNT(*) as total'))
            ->groupBy('dominio')
            ->orderByDesc('nao_ini')
            ->limit(6)->get();

        return view('iso27001.analytics', compact(
            'kpis', 'alertas', 'soaTotal', 'soaAplicaveis', 'soaImpl', 'soaEmImpl',
            'soaPorDominio', 'ativosPorTipo', 'ativosPorClassificacao',
            'incidentesPorTipo', 'incidentesMes', 'matrizRisco', 'triaCia',
            'incidentesRecentes', 'riscosCriticos', 'dominiosPendentes'
        ));
    }
}

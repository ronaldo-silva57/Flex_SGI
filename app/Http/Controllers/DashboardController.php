<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AnaliseRiscoTi;
use App\Models\AspectoAmbiental;
use App\Models\EquipamentoMedicao;
use App\Models\IncidenteAcidente;
use App\Models\IncidenteSeguranca;
use App\Models\LicencaAmbiental;
use App\Models\MudancaGestao;
use App\Models\NaoConformidade;
use App\Models\NaoConformidadeAmbiental;
use App\Models\PerigoRisco;
use App\Models\PlanoAcao;
use App\Models\ReuniaoGestao;
use App\Models\RiscoOportunidade;
use App\Models\SoaControle;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hoje = Carbon::today();

        // ============ SAÚDE POR ISO ============
        $saude = [
            'iso9001' => $this->saude9001(),
            'iso14001' => $this->saude14001(),
            'iso45001' => $this->saude45001(),
            'iso27001' => $this->saude27001(),
        ];

        // ============ RISCOS CONSOLIDADOS (scatter) ============
        // Formato unificado: probabilidade × impacto, com categoria (norma)
        $riscos = [];

        RiscoOportunidade::where('tipo', 'Risco')
            ->whereNotNull('probabilidade')->whereNotNull('impacto')
            ->get(['probabilidade', 'impacto'])
            ->each(fn($r) => $riscos[] = [
                'x' => $r->probabilidade, 'y' => $r->impacto, 'norma' => 'SIG',
            ]);

        PerigoRisco::where('status', 'Ativo')
            ->whereNotNull('probabilidade')->whereNotNull('severidade')
            ->get(['probabilidade', 'severidade'])
            ->each(fn($r) => $riscos[] = [
                'x' => $r->probabilidade, 'y' => $r->severidade, 'norma' => '45001',
            ]);

        AnaliseRiscoTi::whereNotNull('probabilidade')->whereNotNull('impacto')
            ->get(['probabilidade', 'impacto'])
            ->each(fn($r) => $riscos[] = [
                'x' => $r->probabilidade, 'y' => $r->impacto, 'norma' => '27001',
            ]);

        AspectoAmbiental::where('status', 'ativo')
            ->whereNotNull('significancia')
            ->get(['significancia'])
            ->each(fn($r) => $riscos[] = [
                'x' => 3, 'y' => $r->significancia, 'norma' => '14001',
            ]);

        // ============ ALERTAS CONSOLIDADOS ============
        $alertas = [
            // Qualidade
            ['iso' => '9001', 'label' => 'NCs abertas',          'valor' => NaoConformidade::whereNotIn('status', ['Fechada'])->count(),                                    'rota' => route('nao_conformidades.index'),           'cor' => 'red'],
            ['iso' => '9001', 'label' => 'Calibrações vencidas',  'valor' => EquipamentoMedicao::where('status', 'Ativo')->whereDate('proxima_calibracao', '<', $hoje)->count(), 'rota' => route('equipamentos_medicao.index'),        'cor' => 'red'],
            // Ambiental
            ['iso' => '14001', 'label' => 'Licenças vencidas',    'valor' => LicencaAmbiental::where('status', 'Vigente')->whereDate('data_validade', '<', $hoje)->count(),     'rota' => route('licencas_ambientais.index'),         'cor' => 'red'],
            ['iso' => '14001', 'label' => 'NCs ambientais',       'valor' => NaoConformidadeAmbiental::whereNotIn('status', ['Fechada'])->count(),                             'rota' => route('nao_conformidades_ambientais.index'),'cor' => 'red'],
            // SST
            ['iso' => '45001', 'label' => 'Incidentes abertos',   'valor' => IncidenteAcidente::whereIn('status', ['Aberto', 'Em investigação'])->count(),                     'rota' => route('incidentes_acidentes.index'),        'cor' => 'red'],
            ['iso' => '45001', 'label' => 'Perigos alto risco',   'valor' => PerigoRisco::where('status', 'Ativo')->where('nivel_risco', '>=', 15)->count(),                   'rota' => route('perigos_riscos.index'),              'cor' => 'amber'],
            // Segurança info
            ['iso' => '27001', 'label' => 'Incidentes SGSI',      'valor' => IncidenteSeguranca::whereIn('status', ['Aberto', 'Em investigação'])->count(),                    'rota' => route('incidentes_seguranca.index'),        'cor' => 'red'],
            ['iso' => '27001', 'label' => 'Riscos residual alto', 'valor' => AnaliseRiscoTi::where('nivel_risco_residual', '>=', 15)->count(),                                 'rota' => route('analises_risco_ti.index'),           'cor' => 'amber'],
            // Transversal
            ['iso' => 'SIG',  'label' => 'Planos atrasados',      'valor' => PlanoAcao::whereIn('status', ['Pendente', 'Em andamento'])->whereNotNull('prazo_fim')->whereDate('prazo_fim', '<', $hoje)->count(), 'rota' => route('planos_acao.index'), 'cor' => 'red'],
            ['iso' => 'SIG',  'label' => 'Mudanças pendentes',    'valor' => MudancaGestao::whereIn('status', ['Proposta', 'Em analise'])->count(),                            'rota' => route('mudancas_gestao.index'),             'cor' => 'amber'],
        ];

        // ============ PLANOS DE AÇÃO POR NORMA DE ORIGEM (morph) ============
        $planosPorOrigem = PlanoAcao::select('origem_type', DB::raw('COUNT(*) as total'))
            ->groupBy('origem_type')->pluck('total', 'origem_type')
            ->mapWithKeys(fn($v, $k) => [class_basename($k) => $v]);

        // ============ AUDITORIAS ============
        $auditoriasStatus = DB::table('auditorias')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        // ============ ÚLTIMA REVISÃO PELA DIREÇÃO ============
        $ultimaRevisao = ReuniaoGestao::where('tipo', 'Revisão Direção')
            ->orderByDesc('data_reuniao')->first();

        // ============ PLANOS DE AÇÃO CRÍTICOS (Top 5) ============
        $planosCriticos = PlanoAcao::with('responsavel')
            ->whereIn('status', ['Pendente', 'Em andamento'])
            ->whereNotNull('prazo_fim')
            ->orderBy('prazo_fim')->limit(5)
            ->get(['id', 'codigo', 'titulo', 'progresso', 'prazo_fim', 'status', 'responsavel_id', 'origem_type']);

        return view('cadastros.dashboard', compact(
            'saude', 'riscos', 'alertas', 'planosPorOrigem',
            'auditoriasStatus', 'ultimaRevisao', 'planosCriticos'
        ));
    }

    private function saude9001(): array
    {
        $total    = NaoConformidade::count();
        $fechadas = NaoConformidade::where('status', 'Fechada')->count();
        $pct      = $total > 0 ? round(($fechadas / $total) * 100) : 100;

        return [
            'nome'    => 'ISO 9001',
            'subtitulo' => 'Qualidade',
            'pct'     => $pct,
            'cor'     => $pct >= 80 ? 'emerald' : ($pct >= 60 ? 'amber' : 'red'),
            'detalhes' => [
                'NCs fechadas'   => "$fechadas / $total",
                'NCs abertas'    => NaoConformidade::whereNotIn('status', ['Fechada'])->count(),
                'Calibrações venc.' => EquipamentoMedicao::where('status', 'Ativo')
                    ->whereDate('proxima_calibracao', '<', now())->count(),
            ],
            'rota' => route('iso9001.analytics'),
        ];
    }

    private function saude14001(): array
    {
        $total    = NaoConformidadeAmbiental::count();
        $fechadas = NaoConformidadeAmbiental::where('status', 'Fechada')->count();
        $pct      = $total > 0 ? round(($fechadas / $total) * 100) : 100;

        return [
            'nome'    => 'ISO 14001',
            'subtitulo' => 'Ambiental',
            'pct'     => $pct,
            'cor'     => $pct >= 80 ? 'emerald' : ($pct >= 60 ? 'amber' : 'red'),
            'detalhes' => [
                'NCs fechadas'     => "$fechadas / $total",
                'Licenças vigentes' => LicencaAmbiental::where('status', 'Vigente')->count(),
                'Licenças a vencer' => LicencaAmbiental::where('status', 'Vigente')
                    ->whereBetween('data_validade', [now(), now()->addDays(60)])->count(),
            ],
            'rota' => route('iso14001.analytics'),
        ];
    }

    private function saude45001(): array
    {
        $ultimo = IncidenteAcidente::whereIn('tipo', ['Acidente leve', 'Acidente grave', 'Fatal'])
            ->orderByDesc('data_ocorrencia')->first();
        $dias   = $ultimo ? Carbon::parse($ultimo->data_ocorrencia)->diffInDays(now()) : null;

        $pct = $dias === null ? 100 : ($dias >= 90 ? 100 : ($dias >= 30 ? 75 : 50));

        return [
            'nome'    => 'ISO 45001',
            'subtitulo' => 'SST',
            'pct'     => $pct,
            'cor'     => $pct >= 80 ? 'emerald' : ($pct >= 60 ? 'amber' : 'red'),
            'detalhes' => [
                'Dias sem acidente' => $dias ?? '—',
                'Incidentes abertos'=> IncidenteAcidente::whereIn('status', ['Aberto', 'Em investigação'])->count(),
                'Perigos alto risco'=> PerigoRisco::where('status', 'Ativo')->where('nivel_risco', '>=', 15)->count(),
            ],
            'rota' => route('iso45001.analytics'),
        ];
    }

    private function saude27001(): array
    {
        $aplicaveis = SoaControle::where('aplicavel', true)->count();
        $impl       = SoaControle::where('aplicavel', true)
            ->where('status_implementacao', 'Implementado')->count();
        $pct        = $aplicaveis > 0 ? round(($impl / $aplicaveis) * 100) : 0;

        return [
            'nome'    => 'ISO 27001',
            'subtitulo' => 'Segurança da Informação',
            'pct'     => $pct,
            'cor'     => $pct >= 80 ? 'emerald' : ($pct >= 50 ? 'amber' : 'red'),
            'detalhes' => [
                'Controles implementados' => "$impl / $aplicaveis",
                'Riscos resid. alto'      => AnaliseRiscoTi::where('nivel_risco_residual', '>=', 15)->count(),
                'Incidentes abertos'      => IncidenteSeguranca::whereIn('status', ['Aberto', 'Em investigação'])->count(),
            ],
            'rota' => route('iso27001.analytics'),
        ];
    }
}
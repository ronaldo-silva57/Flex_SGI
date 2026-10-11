<?php

namespace App\Services;

use App\Models\AnaliseRiscoTi;
use App\Models\AspectoAmbiental;
use App\Models\Auditoria;
use App\Models\Documento;
use App\Models\EquipamentoMedicao;
use App\Models\ExameMedico;
use App\Models\IncidenteAcidente;
use App\Models\IncidenteSeguranca;
use App\Models\LicencaAmbiental;
use App\Models\NaoConformidade;
use App\Models\NaoConformidadeAmbiental;
use App\Models\PerigoRisco;
use App\Models\PesquisaSatisfacaoResposta;
use App\Models\PlanoAcao;
use App\Models\ReuniaoGestao;
use App\Models\SoaControle;
use App\Models\TreinamentoUsuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RelatorioRevisaoDirecaoService
{
    public function gerar(?Carbon $referencia = null): array
    {
        $ref    = $referencia ?? now();
        $iniMes = $ref->copy()->startOfMonth();
        $fimMes = $ref->copy()->endOfMonth();

        return [
            'periodo'    => $ref->translatedFormat('F/Y'),
            'ini_mes'    => $iniMes,
            'fim_mes'    => $fimMes,
            'gerado_em'  => now(),
            'empresa'    => config('app.name'),
            'iso9001'    => $this->iso9001($iniMes, $fimMes),
            'iso14001'   => $this->iso14001($iniMes, $fimMes),
            'iso45001'   => $this->iso45001($iniMes, $fimMes),
            'iso27001'   => $this->iso27001($iniMes, $fimMes),
            'sig'        => $this->sig($iniMes, $fimMes),
        ];
    }

    private function iso9001(Carbon $ini, Carbon $fim): array
    {
        $ncTotal    = NaoConformidade::count();
        $ncFechadas = NaoConformidade::where('status', 'Fechada')->count();
        $ncNovas    = NaoConformidade::whereBetween('created_at', [$ini, $fim])->count();
        $ncAbertas  = NaoConformidade::whereNotIn('status', ['Fechada'])->count();
        
        $calibracoesVencidas = EquipamentoMedicao::where('status', 'Ativo')
            ->whereDate('proxima_calibracao', '<', now())->count();

        $npsBase = PesquisaSatisfacaoResposta::whereNotNull('classificacao')
            ->whereBetween('respondido_em', [$ini->copy()->subMonths(12), now()])
            ->select('classificacao', DB::raw('COUNT(*) as total'))
            ->groupBy('classificacao')->pluck('total', 'classificacao');

        $promotores = $npsBase['Promotor'] ?? 0;
        $detratores = $npsBase['Detrator'] ?? 0;
        $totalNps   = $npsBase->sum();
        $npsScore   = $totalNps > 0 ? round((($promotores - $detratores) / $totalNps) * 100, 1) : null;

        return [
            'titulo'           => 'ISO 9001 — Gestão da Qualidade',
            'conformidade_pct' => $ncTotal > 0 ? round(($ncFechadas / $ncTotal) * 100) : 100,
            'kpis' => [
                'NCs abertas'          => $ncAbertas,
                'NCs novas no mês'     => $ncNovas,
                'NCs fechadas / total' => "$ncFechadas / $ncTotal",
                'Calibrações vencidas' => $calibracoesVencidas,
                'NPS (12 meses)'       => $npsScore !== null ? $npsScore : '—',
                'Respostas de pesquisa'=> $totalNps,
            ],
            'grafico_nc_origem' => NaoConformidade::whereBetween('created_at', [$ini->copy()->subMonths(6), $fim])
                ->select('origem', DB::raw('COUNT(*) as total'))
                ->groupBy('origem')->pluck('total', 'origem')->toArray(),
            'grafico_nc_status' => NaoConformidade::select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')->pluck('total', 'status')->toArray(),
            'alertas' => [
                'Calibrações vencidas'    => $calibracoesVencidas,
                'NCs atrasadas'           => NaoConformidade::whereNotIn('status', ['Fechada'])
                    ->whereNotNull('prazo_tratamento')->whereDate('prazo_tratamento', '<', now())->count(),
                'NCs Alta/Crítica abertas'=> NaoConformidade::whereNotIn('status', ['Fechada'])
                    ->whereIn('gravidade', ['Alta', 'Crítica'])->count(),
            ],
        ];
    }

    private function iso14001(Carbon $ini, Carbon $fim): array
    {
        $ncTotal    = NaoConformidadeAmbiental::count();
        $ncFechadas = NaoConformidadeAmbiental::where('status', 'Fechada')->count();
        $licencasVencidas = LicencaAmbiental::where('status', 'Vigente')->whereDate('data_validade', '<', now())->count();
        $licencasProximas = LicencaAmbiental::where('status', 'Vigente')->whereBetween('data_validade', [now(), now()->addDays(30)])->count();
        $ncAltasCriticas  = NaoConformidadeAmbiental::whereNotIn('status', ['Fechada'])->whereIn('gravidade', ['Alta', 'Crítica'])->count();

        return [
            'titulo' => 'ISO 14001 — Gestão Ambiental',
            'conformidade_pct' => $ncTotal > 0 ? round(($ncFechadas / $ncTotal) * 100) : 100,
            'kpis' => [
                'Licenças vigentes'         => LicencaAmbiental::where('status', 'Vigente')->count(),
                'Licenças a vencer (30 dias)'=> $licencasProximas,
                'Aspectos significativos'   => AspectoAmbiental::where('status', 'ativo')->where('significancia', '>=', 4)->count(),
                'NCs ambientais abertas'    => NaoConformidadeAmbiental::whereNotIn('status', ['Fechada'])->count(),
                'NCs fechadas / total'      => "$ncFechadas / $ncTotal",
            ],
            'grafico_nc_origem' => NaoConformidadeAmbiental::whereBetween('created_at', [$ini->copy()->subMonths(6), $fim])
                ->select('origem', DB::raw('COUNT(*) as total'))
                ->groupBy('origem')->pluck('total', 'origem')->toArray(),
            'grafico_nc_status' => NaoConformidadeAmbiental::select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')->pluck('total', 'status')->toArray(),
            'alertas' => [
                'Licenças vencidas'           => $licencasVencidas,
                'Licenças vencendo (30 dias)' => $licencasProximas,
                'NCs Alta/Crítica abertas'    => $ncAltasCriticas,
            ],
        ];
    }

    private function iso45001(Carbon $ini, Carbon $fim): array
    {
        $ultimo = IncidenteAcidente::whereIn('tipo', ['Acidente leve', 'Acidente grave', 'Fatal'])
            ->orderByDesc('data_ocorrencia')->first();
        $diasSemAc = $ultimo ? Carbon::parse($ultimo->data_ocorrencia)->diffInDays(now()) : null;

        $incMes = IncidenteAcidente::whereBetween('data_ocorrencia', [$ini, $fim])->count();
        $diasPerdMes = IncidenteAcidente::whereBetween('data_ocorrencia', [$ini, $fim])->sum('dias_perdidos');
        
        $incidentesAbertos = IncidenteAcidente::whereIn('status', ['Aberto', 'Em investigação'])->count();
        $perigosAltoRisco = PerigoRisco::where('status', 'Ativo')->where('nivel_risco', '>=', 15)->count();
        $asosVencidos = ExameMedico::where('status', 'Vigente')->whereDate('data_vencimento', '<', now())->count();

        return [
            'titulo' => 'ISO 45001 — Segurança e Saúde no Trabalho',
            'destaque' => $diasSemAc,
            'kpis' => [
                'Dias sem acidente'        => $diasSemAc ?? '—',
                'Incidentes no mês'        => $incMes,
                'Dias perdidos no mês'     => $diasPerdMes,
                'Incidentes abertos'       => $incidentesAbertos,
                'Perigos ativos'           => PerigoRisco::where('status', 'Ativo')->count(),
                'Perigos de alto risco (NR ≥ 15)' => $perigosAltoRisco,
                'ASOs vencendo (60 days)'  => ExameMedico::where('status', 'Vigente')
                    ->whereBetween('data_vencimento', [now(), now()->addDays(60)])->count(),
            ],
            'grafico_inc_tipo' => IncidenteAcidente::whereBetween('data_ocorrencia', [$ini->copy()->subMonths(6), $fim])
                ->select('tipo', DB::raw('COUNT(*) as total'))
                ->groupBy('tipo')->pluck('total', 'tipo')->toArray(),
            'grafico_perigos_nivel' => PerigoRisco::where('status', 'Ativo')
                ->whereNotNull('nivel_risco')
                ->select('nivel_risco', DB::raw('COUNT(*) as total'))
                ->groupBy('nivel_risco')->pluck('total', 'nivel_risco')->toArray(),
            'alertas' => [
                'Incidentes abertos'    => $incidentesAbertos,
                'Perigos de alto risco' => $perigosAltoRisco,
                'ASOs vencidos'         => $asosVencidos,
                'EPIs vencidos'         => DB::table('epis_usuarios')
                    ->where('status', 'Ativo')->whereDate('data_vencimento', '<', now())->count(),
            ],
        ];
    }

    private function iso27001(Carbon $ini, Carbon $fim): array
    {
        $aplicaveis = SoaControle::where('aplicavel', true)->count();
        $impl       = SoaControle::where('aplicavel', true)
            ->where('status_implementacao', 'Implementado')->count();
        $pctSoa     = $aplicaveis > 0 ? round(($impl / $aplicaveis) * 100) : 0;
        
        $incidentesAbertos = IncidenteSeguranca::whereIn('status', ['Aberto', 'Em investigação'])->count();
        $riscosResiduais = AnaliseRiscoTi::where('nivel_risco_residual', '>=', 15)->count();

        return [
            'titulo' => 'ISO 27001 — Segurança da Informação',
            'conformidade_pct' => $pctSoa,
            'kpis' => [
                'SoA implementado'          => "$impl / $aplicaveis ({$pctSoa}%)",
                'Controles em implementação'=> SoaControle::where('aplicavel', true)
                    ->where('status_implementacao', 'Em implementação')->count(),
                'Ativos de informação'      => \App\Models\AtivoInformacao::where('status', 'Ativo')->count(),
                'Riscos residuais ≥ 15'     => $riscosResiduais,
                'Incidentes no mês'         => IncidenteSeguranca::whereBetween('data_ocorrencia', [$ini, $fim])->count(),
                'Incidentes abertos'        => $incidentesAbertos,
            ],
            'grafico_inc_tipo' => IncidenteSeguranca::whereBetween('data_ocorrencia', [$ini->copy()->subMonths(6), $fim])
                ->select('tipo', DB::raw('COUNT(*) as total'))
                ->groupBy('tipo')->pluck('total', 'tipo')->toArray(),
            'grafico_soa' => SoaControle::where('aplicavel', true)
                ->select('status_implementacao', DB::raw('COUNT(*) as total'))
                ->groupBy('status_implementacao')->pluck('total', 'status_implementacao')->toArray(),
            'alertas' => [
                'Incidentes abertos'      => $incidentesAbertos,
                'Riscos residuais ≥ 15'   => $riscosResiduais,
                'Controles não iniciados' => SoaControle::where('aplicavel', true)
                    ->where('status_implementacao', 'Não iniciado')->count(),
                'Controles sem evidência' => SoaControle::where('aplicavel', true)
                    ->where('status_implementacao', 'Implementado')
                    ->whereNull('evidencia_path')->count(),
            ],
        ];
    }

    private function sig(Carbon $ini, Carbon $fim): array
    {
        $planosAbertos = PlanoAcao::whereIn('status', ['Pendente', 'Em andamento'])->count();
        $planosAtrasados = PlanoAcao::whereIn('status', ['Pendente', 'Em andamento'])
            ->whereNotNull('prazo_fim')->whereDate('prazo_fim', '<', now())->count();
        
        $treinamentosVencidos = TreinamentoUsuario::where('status', 'Vencido')->count();

        $planosPorOrigem = PlanoAcao::select('origem_type', DB::raw('COUNT(*) as total'))
            ->groupBy('origem_type')->pluck('total', 'origem_type')
            ->mapWithKeys(fn($v, $k) => [$k ? class_basename($k) : 'Manual' => $v])->toArray();

        return [
            'titulo' => 'SIG — Sistema Integrado de Gestão',
            'kpis' => [
                'Planos de ação abertos'    => $planosAbertos,
                'Planos atrasados'          => $planosAtrasados,
                'Auditorias realizadas (ano)'=> Auditoria::whereYear('data_inicio', now()->year)->count(),
                'Documentos aprovados'      => Documento::where('status', 'Aprovado')->count(),
                'Treinamentos vencidos'     => $treinamentosVencidos,
                'Mudanças pendentes'        => DB::table('mudancas_gestao')
                    ->whereIn('status', ['Proposta', 'Em analise'])->count(),
            ],
            'grafico_planos_origem' => $planosPorOrigem,
            'grafico_planos_status' => PlanoAcao::select('status', DB::raw('COUNT(*) as total'))
                ->groupBy('status')->pluck('total', 'status')->toArray(),
            'ultima_revisao' => ReuniaoGestao::where('tipo', 'Revisão Direção')
                ->orderByDesc('data_reuniao')->first(),
            'alertas' => [
                'Planos atrasados'      => $planosAtrasados,
                'Auditorias planejadas' => Auditoria::where('status', 'Planejada')->count(),
                'Docs em revisão'       => Documento::where('status', 'Em revisão')->count(),
                'Treinamentos vencidos' => $treinamentosVencidos,
            ],
        ];
    }
}
<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Auditoria;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Documento;
use App\Models\Fornecedor;
use App\Models\AvaliacaoFornecedor;
use App\Models\MudancaGestao;
use App\Models\NaoConformidade;
use App\Models\PlanoAcao;
use App\Models\RiscoOportunidade;
use App\Models\Treinamento;
use App\Models\TreinamentoUsuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsGeralController extends Controller
{
    public function index()
    {
        $hoje   = Carbon::today();
        $em30   = Carbon::today()->addDays(30);
        $em60   = Carbon::today()->addDays(60);
        $iniAno = Carbon::today()->startOfYear();

        // ---------- KPIs ----------
        $kpis = [
            'departamentos_ativos' => Departamento::where('ativo', true)->count(),
            'clientes_ativos'      => Cliente::where('status', 'ativo')->count(),
            'fornecedores_ativos'  => Fornecedor::where('ativo', true)->count(),
            'documentos_aprovados' => Documento::where('status', 'Aprovado')->count(),
        ];

        // ---------- Alertas ----------
        $alertas = [
            'nc_abertas' => NaoConformidade::whereNotIn('status', ['Fechada'])->count(),

            'nc_atrasadas' => NaoConformidade::whereNotIn('status', ['Fechada'])
                ->whereNotNull('prazo_tratamento')
                ->whereDate('prazo_tratamento', '<', $hoje)->count(),

            'nc_graves_abertas' => NaoConformidade::whereNotIn('status', ['Fechada'])
                ->whereIn('gravidade', ['Alta', 'Crítica'])->count(),

            'auditorias_abertas' => Auditoria::whereIn('status', ['Planejada', 'Em andamento'])->count(),

            'auditorias_atrasadas' => Auditoria::where('status', 'Planejada')
                ->whereNotNull('data_inicio')
                ->whereDate('data_inicio', '<', $hoje)->count(),

            'documentos_revisao' => Documento::where('status', 'Em revisão')->count(),

            'documentos_vencidos' => Documento::where('status', 'Aprovado')
                ->whereNotNull('data_revisao')
                ->whereDate('data_revisao', '<', $hoje)->count(),

            'treinamentos_vencidos' => TreinamentoUsuario::where(function ($q) use ($hoje) {
                    $q->where('status', 'Vencido')
                      ->orWhere(function ($q2) use ($hoje) {
                          $q2->whereNotNull('validade_ate')->whereDate('validade_ate', '<', $hoje);
                      });
                })->count(),

            'treinamentos_pendentes' => TreinamentoUsuario::where('status', 'Pendente')->count(),

            'planos_atrasados' => PlanoAcao::whereIn('status', ['Pendente', 'Em andamento'])
                ->whereNotNull('prazo_fim')
                ->whereDate('prazo_fim', '<', $hoje)->count(),

            'mudancas_pendentes' => MudancaGestao::whereIn('status', ['Proposta', 'Em analise'])
                ->count(),

            'fornecedores_reprovados' => AvaliacaoFornecedor::where('status_qualificacao', 'Reprovado')
                ->where('periodo_referencia', '>=', $iniAno->format('Y') . '-01')
                ->count(),
        ];

        // ---------- Gráfico: NCs por origem ----------
        $ncPorOrigem = NaoConformidade::select('origem', DB::raw('COUNT(*) as total'))
            ->groupBy('origem')->pluck('total', 'origem');

        // ---------- Gráfico: NCs por status ----------
        $ncPorStatus = NaoConformidade::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        // ---------- Gráfico: NCs por gravidade ----------
        $ncPorGravidade = NaoConformidade::whereNotNull('gravidade')
            ->select('gravidade', DB::raw('COUNT(*) as total'))
            ->groupBy('gravidade')->pluck('total', 'gravidade');

        // ---------- Gráfico: Auditorias por tipo/status ----------
        $auditoriasPorTipo = Auditoria::select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')->pluck('total', 'tipo');

        $auditoriasPorStatus = Auditoria::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        // ---------- Gráfico: Documentos por status ----------
        $documentosPorStatus = Documento::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        // ---------- Gráfico: Planos de ação por status ----------
        $planosPorStatus = PlanoAcao::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        // ---------- Gráfico: Treinamentos (concluídos vs pendentes vs vencidos) ----------
        $treinamentosPorStatus = TreinamentoUsuario::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        // ---------- Gráfico: Avaliações de fornecedores ----------
        $avalFornec = AvaliacaoFornecedor::select('status_qualificacao', DB::raw('COUNT(*) as total'))
            ->groupBy('status_qualificacao')->pluck('total', 'status_qualificacao');

        // ---------- Gráfico: Riscos vs Oportunidades ----------
        $riscosOport = RiscoOportunidade::select('tipo', DB::raw('COUNT(*) as total'))
            ->groupBy('tipo')->pluck('total', 'tipo');

        // ---------- Gráfico: Auditorias 12 meses ----------
        $auditoriasMes = Auditoria::select(
                DB::raw("TO_CHAR(data_inicio, 'YYYY-MM') as mes"),
                DB::raw('COUNT(*) as total')
            )
            ->where('data_inicio', '>=', $hoje->copy()->subMonths(12))
            ->groupBy('mes')->orderBy('mes')->get();

        // ---------- Listas acionáveis ----------
        $ncAtrasadas = NaoConformidade::whereNotIn('status', ['Fechada'])
            ->whereNotNull('prazo_tratamento')
            ->whereDate('prazo_tratamento', '<', $hoje)
            ->orderBy('prazo_tratamento')->limit(5)
            ->get(['id', 'codigo', 'titulo', 'gravidade', 'prazo_tratamento', 'status']);

        $planosAtrasados = PlanoAcao::whereIn('status', ['Pendente', 'Em andamento'])
            ->whereNotNull('prazo_fim')
            ->whereDate('prazo_fim', '<', $hoje)
            ->orderBy('prazo_fim')->limit(5)
            ->get(['id', 'codigo', 'titulo', 'progresso', 'prazo_fim', 'status']);

        $documentosRevisao = Documento::whereIn('status', ['Em revisão', 'Rascunho'])
            ->orderByDesc('updated_at')->limit(5)
            ->get(['id', 'codigo', 'titulo', 'versao', 'status', 'updated_at']);

        $proximasAuditorias = Auditoria::whereIn('status', ['Planejada', 'Em andamento'])
            ->whereNotNull('data_inicio')
            ->orderBy('data_inicio')->limit(5)
            ->get(['id', 'tipo', 'data_inicio', 'data_fim', 'status']);

        $treinamentosVencendo = TreinamentoUsuario::with(['treinamento', 'usuario'])
            ->where('status', 'Concluído')
            ->whereBetween('validade_ate', [$hoje, $em60])
            ->orderBy('validade_ate')->limit(5)
            ->get();

        return view('cadastros.analytics', compact(
            'kpis', 'alertas',
            'ncPorOrigem', 'ncPorStatus', 'ncPorGravidade',
            'auditoriasPorTipo', 'auditoriasPorStatus', 'auditoriasMes',
            'documentosPorStatus', 'planosPorStatus', 'treinamentosPorStatus',
            'avalFornec', 'riscosOport',
            'ncAtrasadas', 'planosAtrasados', 'documentosRevisao',
            'proximasAuditorias', 'treinamentosVencendo'
        ));
    }
}

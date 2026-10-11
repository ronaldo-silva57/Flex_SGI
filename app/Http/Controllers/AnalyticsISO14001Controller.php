<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AspectoAmbiental;
use App\Models\GestaoResiduo;
use App\Models\IndicadorAmbiental;
use App\Models\LicencaAmbiental;
use App\Models\MonitoramentoAmbiental;
use App\Models\NaoConformidadeAmbiental;
use App\Models\ObjetivoAmbiental;
use App\Models\ProdutoQuimico;
use App\Models\RegistroLegal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AnalyticsISO14001Controller extends Controller
{
    public function index()
    {
        $hoje     = Carbon::today();
        $em30     = Carbon::today()->addDays(30);
        $em60     = Carbon::today()->addDays(60);
        $em90     = Carbon::today()->addDays(90);

        // ---------- KPIs principais ----------
        $kpis = [
            'licencas_vigentes'   => LicencaAmbiental::where('status', 'Vigente')->count(),
            'aspectos_signif'     => AspectoAmbiental::where('status', 'ativo')
                                        ->where('significancia', '>=', 4)->count(),
            'objetivos_ativos'    => ObjetivoAmbiental::whereIn('status', ['Planejado', 'Em andamento'])->count(),
            'nc_abertas'          => NaoConformidadeAmbiental::whereNotIn('status', ['Fechada'])->count(),
        ];

        // ---------- Alertas ----------
        $alertas = [
            'licencas_vencidas' => LicencaAmbiental::where('status', 'Vigente')
                ->whereDate('data_validade', '<', $hoje)->count(),

            'licencas_30dias' => LicencaAmbiental::where('status', 'Vigente')
                ->whereBetween('data_validade', [$hoje, $em30])->count(),

            'licencas_60dias' => LicencaAmbiental::where('status', 'Vigente')
                ->whereBetween('data_validade', [$em30, $em60])->count(),

            'objetivos_atrasados' => ObjetivoAmbiental::where('status', '!=', 'Concluído')
                ->whereNotNull('prazo')
                ->whereDate('prazo', '<', $hoje)->count(),

            'nc_alta_gravidade' => NaoConformidadeAmbiental::whereNotIn('status', ['Fechada'])
                ->whereIn('gravidade', ['Alta', 'Crítica'])->count(),

            'monitoramentos_atrasados' => MonitoramentoAmbiental::where('status', 'Atrasado')->count(),

            'quimicos_vencidos' => ProdutoQuimico::where('status', 'Ativo')
                ->whereNotNull('data_validade')
                ->whereDate('data_validade', '<', $hoje)->count(),

            'registros_em_revisao' => RegistroLegal::where('status', 'Em revisão')->count(),
        ];

        // ---------- Gráfico: Licenças por tipo/status ----------
        $licencasPorStatus = LicencaAmbiental::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')->pluck('total', 'status');

        // ---------- Gráfico: Resíduos por classe ----------
        $residuosPorClasse = GestaoResiduo::where('status', 'Ativo')
            ->select('classe', DB::raw('COUNT(*) as total'))
            ->groupBy('classe')->pluck('total', 'classe');

        // ---------- Gráfico: Resíduos por destino final ----------
        $residuosPorDestino = GestaoResiduo::where('status', 'Ativo')
            ->whereNotNull('destino_final')
            ->select('destino_final', DB::raw('COUNT(*) as total'))
            ->groupBy('destino_final')->orderByDesc('total')->limit(6)
            ->pluck('total', 'destino_final');

        // ---------- Gráfico: NCs por origem ----------
        $ncPorOrigem = NaoConformidadeAmbiental::select('origem', DB::raw('COUNT(*) as total'))
            ->groupBy('origem')->pluck('total', 'origem');

        // ---------- Gráfico: Aspectos por significância ----------
        $aspectosSignificancia = AspectoAmbiental::where('status', 'ativo')
            ->select('significancia', DB::raw('COUNT(*) as total'))
            ->groupBy('significancia')->orderBy('significancia')
            ->pluck('total', 'significancia');

        // ---------- Gráfico: Monitoramentos ambientais (12 meses) ----------
        $monitoramentosMes = MonitoramentoAmbiental::select(
                DB::raw("TO_CHAR(created_at, 'YYYY-MM') as mes"),
                DB::raw('COUNT(*) as total'),
                DB::raw("SUM(CASE WHEN status = 'Atrasado' THEN 1 ELSE 0 END) as atrasados")
            )
            ->where('created_at', '>=', $hoje->copy()->subMonths(12))
            ->groupBy('mes')->orderBy('mes')->get();

        // ---------- Listas acionáveis ----------
        $proximasLicencas = LicencaAmbiental::where('status', 'Vigente')
            ->whereBetween('data_validade', [$hoje, $em90])
            ->orderBy('data_validade')->limit(6)
            ->get(['id', 'numero', 'tipo', 'orgao_emissor', 'data_validade']);

        $ncCriticas = NaoConformidadeAmbiental::whereNotIn('status', ['Fechada'])
            ->whereIn('gravidade', ['Alta', 'Crítica'])
            ->orderByDesc('data_abertura')->limit(5)
            ->get(['id', 'codigo', 'titulo', 'gravidade', 'prazo_tratamento', 'status']);

        $objetivosEmRisco = ObjetivoAmbiental::where('status', '!=', 'Concluído')
            ->where(function ($q) use ($hoje) {
                $q->where('status', 'Atrasado')
                  ->orWhere(function ($q2) use ($hoje) {
                      $q2->whereNotNull('prazo')->whereDate('prazo', '<', $hoje->copy()->addDays(15));
                  });
            })
            ->orderBy('prazo')->limit(5)
            ->get(['id', 'codigo', 'titulo', 'progresso', 'prazo', 'status']);

        return view('iso14001.analytics', compact(
            'kpis', 'alertas',
            'licencasPorStatus', 'residuosPorClasse', 'residuosPorDestino',
            'ncPorOrigem', 'aspectosSignificancia', 'monitoramentosMes',
            'proximasLicencas', 'ncCriticas', 'objetivosEmRisco'
        ));
    }
}

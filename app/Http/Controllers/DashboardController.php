<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public const FAIXAS = ['Vencido', '7 dias', '30 dias', '60 dias', '90 dias'];

    public function index(Request $request): View
    {
        $empresaId = auth()->user()->empresa_id ?? 1;

        $kpis = DB::table('vw_kpis_executivos')
            ->where('empresa_id', $empresaId)
            ->first();

        $vencimentos = DB::table('vw_agenda_vencimentos')
            ->select('modulo', DB::raw("
                CASE
                    WHEN dias_restantes < 0 THEN 'Vencido'
                    WHEN dias_restantes <= 7 THEN '7 dias'
                    WHEN dias_restantes <= 30 THEN '30 dias'
                    WHEN dias_restantes <= 60 THEN '60 dias'
                    WHEN dias_restantes <= 90 THEN '90 dias'
                    ELSE 'Futuro'
                END AS faixa
            "), DB::raw('COUNT(*) as total'))
            ->where('empresa_id', $empresaId)
            ->where('dias_restantes', '<=', 90)
            ->groupBy('modulo', 'faixa')
            ->orderBy('modulo')
            ->get();

        $ncGravidade = DB::table('nao_conformidades')
            ->select('gravidade', DB::raw('COUNT(*) as total'))
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->groupBy('gravidade')
            ->get();

        $ncStatus = DB::table('nao_conformidades')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->groupBy('status')
            ->get();

        $acoes = DB::table('acoes_corretivas as ac')
            ->join('nao_conformidades as nc', 'nc.id', '=', 'ac.nao_conformidade_id')
            ->select('ac.etapa', 'ac.status', DB::raw('COUNT(*) as total'))
            ->where('nc.empresa_id', $empresaId)
            ->whereNull('ac.deleted_at')
            ->groupBy('ac.etapa', 'ac.status')
            ->get();

        $indicadores = DB::table('monitoramentos as m')
            ->join('indicadores as i', 'i.id', '=', 'm.indicador_id')
            ->select(
                'i.codigo', 'i.nome', 'm.periodo_referencia',
                'm.valor_realizado',
                DB::raw('COALESCE(m.valor_meta, i.meta) as meta'),
                'i.tipo_meta', 'i.unidade_medida'
            )
            ->where('i.empresa_id', $empresaId)
            ->whereNull('m.deleted_at')
            ->orderByDesc('m.created_at')
            ->limit(20)
            ->get();

        // ESG removido — sem gráfico correspondente no Blade.
        // Reative quando adicionar o card.

        $matrizRisco = DB::table('riscos_oportunidades')
            ->select('probabilidade', 'impacto', DB::raw('COUNT(*) as total'))
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->where('tipo', 'Risco')
            ->groupBy('probabilidade', 'impacto')
            ->get();

        $incidentes = DB::table('incidentes_acidentes')
            ->select(
                DB::raw("TO_CHAR(data_ocorrencia, 'YYYY-MM') as mes"),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(dias_perdidos) as dias_perdidos')
            )
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->where('data_ocorrencia', '>=', Carbon::now()->subMonths(12)->startOfMonth())
            ->groupByRaw("TO_CHAR(data_ocorrencia, 'YYYY-MM')")
            ->orderByRaw("TO_CHAR(data_ocorrencia, 'YYYY-MM')")
            ->get();

        $auditorias = DB::table('auditorias')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->groupBy('status')
            ->get();

        $proximosVencimentos = DB::table('vw_agenda_vencimentos')
            ->where('empresa_id', $empresaId)
            ->whereBetween('dias_restantes', [-365, 30])
            ->orderBy('dias_restantes')
            ->limit(15)
            ->get();

        return view('cadastros.dashboard.index', compact(
            'kpis',
            'vencimentos',
            'ncGravidade',
            'ncStatus',
            'acoes',
            'indicadores',
            'matrizRisco',
            'incidentes',
            'auditorias',
            'proximosVencimentos',
            'empresaId'
        ));
    }
}
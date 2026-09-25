<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $empresaId = $request->input('empresa_id', 1);

        // KPIs
        $kpis = DB::table('vw_kpis_executivos')
            ->where('empresa_id', $empresaId)
            ->first();

        // Vencimentos por módulo e faixa
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

        // NC por gravidade
        $ncGravidade = DB::table('nao_conformidades')
            ->select('gravidade', DB::raw('COUNT(*) as total'))
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->groupBy('gravidade')
            ->get();

        // NC por status
        $ncStatus = DB::table('nao_conformidades')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->groupBy('status')
            ->get();

        // Ações corretivas por etapa
        $acoes = DB::table('acoes_corretivas as ac')
            ->join('nao_conformidades as nc', 'nc.id', '=', 'ac.nao_conformidade_id')
            ->select('ac.etapa', 'ac.status', DB::raw('COUNT(*) as total'))
            ->where('nc.empresa_id', $empresaId)
            ->whereNull('ac.deleted_at')
            ->groupBy('ac.etapa', 'ac.status')
            ->get();

        // Indicadores meta x realizado
        $indicadores = DB::table('monitoramentos as m')
            ->join('indicadores as i', 'i.id', '=', 'm.indicador_id')
            ->select(
                'i.codigo',
                'i.nome',
                'm.periodo_referencia',
                'm.valor_realizado',
                DB::raw('COALESCE(m.valor_meta, i.meta) as meta'),
                'i.tipo_meta',
                'i.unidade_medida'
            )
            ->where('i.empresa_id', $empresaId)
            ->whereNull('m.deleted_at')
            ->orderByDesc('m.created_at')
            ->limit(20)
            ->get();

        // ESG
        $esg = DB::table('esg_monitoramentos as em')
            ->join('esg_indicadores as ei', 'ei.id', '=', 'em.esg_indicador_id')
            ->select(
                'ei.codigo',
                'ei.nome',
                'ei.dimensao',
                'em.periodo_referencia',
                'em.valor_realizado',
                DB::raw('COALESCE(em.valor_meta, ei.meta) as meta'),
                'ei.unidade_medida'
            )
            ->where('ei.empresa_id', $empresaId)
            ->whereNull('em.deleted_at')
            ->orderByDesc('em.periodo_referencia')
            ->get();

        // Matriz de risco
        $matrizRisco = DB::table('riscos_oportunidades')
            ->select('probabilidade', 'impacto', DB::raw('COUNT(*) as total'))
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->where('tipo', 'Risco')
            ->groupBy('probabilidade', 'impacto')
            ->get();

        // Incidentes por mês
        $incidentes = DB::table('incidentes_acidentes')
            ->select(
                DB::raw("TO_CHAR(data_ocorrencia, 'YYYY-MM') as mes"),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(dias_perdidos) as dias_perdidos')
            )
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Auditorias por status
        $auditorias = DB::table('auditorias')
            ->select('status', DB::raw('COUNT(*) as total'))
            ->where('empresa_id', $empresaId)
            ->whereNull('deleted_at')
            ->groupBy('status')
            ->get();

        // Lista de vencimentos próximos
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
            'esg',
            'matrizRisco',
            'incidentes',
            'auditorias',
            'proximosVencimentos',
            'empresaId'
        ));
    }
}
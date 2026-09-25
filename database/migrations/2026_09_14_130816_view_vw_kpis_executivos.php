<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_kpis_executivos AS
            SELECT
                e.id AS empresa_id,
                (SELECT COUNT(*) FROM nao_conformidades
                    WHERE empresa_id = e.id AND deleted_at IS NULL
                      AND status <> 'Fechada') AS nc_abertas,
                (SELECT COUNT(*) FROM nao_conformidades
                    WHERE empresa_id = e.id AND deleted_at IS NULL
                      AND status = 'Fechada') AS nc_fechadas,
                (SELECT COUNT(*) FROM acoes_corretivas ac
                    JOIN nao_conformidades nc ON nc.id = ac.nao_conformidade_id
                    WHERE nc.empresa_id = e.id AND ac.deleted_at IS NULL
                      AND ac.prazo < CURRENT_DATE
                      AND ac.status <> 'Concluída') AS acoes_atrasadas,
                (SELECT COUNT(*) FROM epis_usuarios eu
                    JOIN epis ep ON ep.id = eu.epi_id
                    WHERE ep.empresa_id = e.id AND eu.deleted_at IS NULL
                      AND eu.data_vencimento < CURRENT_DATE) AS epis_vencidos,
                (SELECT COUNT(*) FROM epis_usuarios eu
                    JOIN epis ep ON ep.id = eu.epi_id
                    WHERE ep.empresa_id = e.id AND eu.deleted_at IS NULL
                      AND eu.data_vencimento BETWEEN CURRENT_DATE AND CURRENT_DATE + 30) AS epis_vencendo_30d,
                (SELECT COUNT(*) FROM treinamentos_usuarios tu
                    JOIN treinamentos t ON t.id = tu.treinamento_id
                    WHERE t.empresa_id = e.id AND tu.deleted_at IS NULL
                      AND tu.validade_ate < CURRENT_DATE) AS treinamentos_vencidos,
                (SELECT COUNT(*) FROM treinamentos_usuarios tu
                    JOIN treinamentos t ON t.id = tu.treinamento_id
                    WHERE t.empresa_id = e.id AND tu.deleted_at IS NULL
                      AND tu.validade_ate BETWEEN CURRENT_DATE AND CURRENT_DATE + 30) AS treinamentos_vencendo_30d,
                (SELECT COUNT(*) FROM documentos
                    WHERE empresa_id = e.id AND deleted_at IS NULL
                      AND data_revisao < CURRENT_DATE) AS documentos_vencidos,
                (SELECT COUNT(*) FROM auditorias
                    WHERE empresa_id = e.id AND deleted_at IS NULL
                      AND data_inicio BETWEEN CURRENT_DATE AND CURRENT_DATE + 30) AS auditorias_30d,
                (SELECT COUNT(*) FROM riscos_oportunidades
                    WHERE empresa_id = e.id AND deleted_at IS NULL
                      AND tipo = 'Risco' AND (probabilidade * impacto) >= 15
                      AND status NOT IN ('Concluído','Cancelado')) AS riscos_criticos,
                (SELECT COUNT(*) FROM incidentes_acidentes
                    WHERE empresa_id = e.id AND deleted_at IS NULL
                      AND status <> 'Concluído') AS incidentes_abertos,
                (SELECT COUNT(*) FROM incidentes_seguranca
                    WHERE empresa_id = e.id AND deleted_at IS NULL
                      AND status <> 'Concluído') AS incidentes_si_abertos,
                (SELECT COUNT(*) FROM perigos_riscos
                    WHERE empresa_id = e.id AND deleted_at IS NULL
                      AND (probabilidade * severidade) >= 15) AS perigos_criticos,
                (SELECT COUNT(*) FROM indicadores i
                    JOIN monitoramentos m ON m.indicador_id = i.id
                    WHERE i.empresa_id = e.id
                      AND m.deleted_at IS NULL
                      AND m.status = 'Atrasado') AS indicadores_fora_meta
            FROM empresas e
            WHERE e.deleted_at IS NULL AND e.ativo = TRUE;
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_kpis_executivos');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            CREATE OR REPLACE VIEW vw_agenda_vencimentos AS
            SELECT
                'EPI'::text AS modulo,
                eu.id AS registro_id,
                e.nome AS item,
                COALESCE(u.name, '—') AS responsavel,
                eu.data_vencimento AS data_vencimento,
                (eu.data_vencimento - CURRENT_DATE) AS dias_restantes,
                eu.status,
                e.empresa_id
            FROM epis_usuarios eu
            JOIN epis e ON e.id = eu.epi_id
            LEFT JOIN users u ON u.id = eu.usuario_id
            WHERE eu.deleted_at IS NULL
              AND eu.data_vencimento IS NOT NULL

            UNION ALL

            SELECT
                'Treinamento',
                tu.id,
                t.titulo,
                COALESCE(u.name, '—'),
                tu.validade_ate,
                (tu.validade_ate - CURRENT_DATE),
                tu.status,
                t.empresa_id
            FROM treinamentos_usuarios tu
            JOIN treinamentos t ON t.id = tu.treinamento_id
            LEFT JOIN users u ON u.id = tu.usuario_id
            WHERE tu.deleted_at IS NULL
              AND tu.validade_ate IS NOT NULL

            UNION ALL

            SELECT
                'Documento',
                d.id,
                d.codigo || ' - ' || d.titulo,
                COALESCE(u.name, '—'),
                d.data_revisao,
                (d.data_revisao - CURRENT_DATE),
                d.status,
                d.empresa_id
            FROM documentos d
            LEFT JOIN users u ON u.id = d.responsavel_id
            WHERE d.deleted_at IS NULL
              AND d.data_revisao IS NOT NULL

            UNION ALL

            SELECT
                'Ação Corretiva',
                ac.id,
                'RNC ' || ac.nao_conformidade_id || ' - ' || ac.etapa,
                COALESCE(u.name, '—'),
                ac.prazo,
                (ac.prazo - CURRENT_DATE),
                ac.status,
                nc.empresa_id
            FROM acoes_corretivas ac
            JOIN nao_conformidades nc ON nc.id = ac.nao_conformidade_id
            LEFT JOIN users u ON u.id = ac.responsavel_id
            WHERE ac.deleted_at IS NULL
              AND ac.prazo IS NOT NULL

            UNION ALL

            SELECT
                'Risco/Oportunidade',
                ro.id,
                ro.tipo || ' - ' || LEFT(ro.descricao, 80),
                COALESCE(u.name, '—'),
                ro.prazo,
                (ro.prazo - CURRENT_DATE),
                ro.status,
                ro.empresa_id
            FROM riscos_oportunidades ro
            LEFT JOIN users u ON u.id = ro.responsavel_id
            WHERE ro.deleted_at IS NULL
              AND ro.prazo IS NOT NULL

            UNION ALL

            SELECT
                'Registro Legal',
                rl.id,
                rl.numero || ' - ' || LEFT(rl.descricao, 80),
                '—',
                rl.data_vigencia,
                (rl.data_vigencia - CURRENT_DATE),
                rl.status,
                rl.empresa_id
            FROM registros_legais rl
            WHERE rl.deleted_at IS NULL
              AND rl.data_vigencia IS NOT NULL

            UNION ALL

            SELECT
                'Auditoria',
                a.id,
                COALESCE(a.escopo, 'Auditoria ' || a.tipo),
                COALESCE(u.name, '—'),
                a.data_inicio,
                (a.data_inicio - CURRENT_DATE),
                a.status,
                a.empresa_id
            FROM auditorias a
            LEFT JOIN users u ON u.id = a.auditor_lider_id
            WHERE a.deleted_at IS NULL
              AND a.data_inicio IS NOT NULL

            UNION ALL

            SELECT
                'Reunião',
                rg.id,
                rg.tipo,
                COALESCE(u.name, '—'),
                rg.proxima_reuniao,
                (rg.proxima_reuniao - CURRENT_DATE),
                'Planejada',
                rg.empresa_id
            FROM reunioes_gestao rg
            LEFT JOIN users u ON u.id = rg.responsavel_id
            WHERE rg.deleted_at IS NULL
              AND rg.proxima_reuniao IS NOT NULL;
        ");
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS vw_agenda_vencimentos');
    }
};
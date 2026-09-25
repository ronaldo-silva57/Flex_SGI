<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('controles_seguranca', function (Blueprint $table) {
            $table->string('status_implementacao', 50)->default('nao_iniciado');
            $table->text('justificativa')->nullable();
            $table->date('data_revisao')->nullable();
            $table->unsignedSmallInteger('efetividade')->nullable();
            $table->index(['empresa_id', 'status_implementacao']);
        });

        Schema::table('registros_legais', function (Blueprint $table) {
            $table->date('data_revisao')->nullable();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('proxima_avaliacao')->nullable();
            $table->index(['empresa_id', 'status', 'proxima_avaliacao']);
        });

        Schema::table('documentos', function (Blueprint $table) {
            $table->foreignId('criado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('aprovado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampTz('publicado_em')->nullable();
            $table->string('hash_arquivo', 64)->nullable();
            $table->index(['empresa_id', 'status', 'data_revisao']);
        });

        Schema::table('auditorias', function (Blueprint $table) {
            $table->foreignId('programa_auditoria_id')->nullable()->constrained('programas_auditoria')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->index(['empresa_id', 'status', 'data_inicio']);
        });

        Schema::table('nao_conformidades', function (Blueprint $table) {
            $table->foreignId('auditoria_id')->nullable()->constrained('auditorias')->nullOnDelete();
            $table->foreignId('acao_id')->nullable()->constrained('acoes')->nullOnDelete();
            $table->date('prazo')->nullable();
            $table->date('data_verificacao')->nullable();
            $table->boolean('eficaz')->nullable();
            $table->index(['empresa_id', 'status', 'gravidade']);
        });
    }

    public function down(): void
    {
        Schema::table('nao_conformidades', function (Blueprint $table) {
            $table->dropIndex(['empresa_id', 'status', 'gravidade']);
            $table->dropForeign(['auditoria_id']);
            $table->dropForeign(['acao_id']);
            $table->dropColumn(['auditoria_id', 'acao_id', 'prazo', 'data_verificacao', 'eficaz']);
        });

        Schema::table('auditorias', function (Blueprint $table) {
            $table->dropIndex(['empresa_id', 'status', 'data_inicio']);
            $table->dropForeign(['programa_auditoria_id']);
            $table->dropForeign(['responsavel_id']);
            $table->dropColumn(['programa_auditoria_id', 'responsavel_id']);
        });

        Schema::table('documentos', function (Blueprint $table) {
            $table->dropIndex(['empresa_id', 'status', 'data_revisao']);
            $table->dropForeign(['criado_por']);
            $table->dropForeign(['aprovado_por']);
            $table->dropColumn(['criado_por', 'aprovado_por', 'publicado_em', 'hash_arquivo']);
        });

        Schema::table('registros_legais', function (Blueprint $table) {
            $table->dropIndex(['empresa_id', 'status', 'proxima_avaliacao']);
            $table->dropForeign(['responsavel_id']);
            $table->dropColumn(['data_revisao', 'responsavel_id', 'proxima_avaliacao']);
        });

        Schema::table('controles_seguranca', function (Blueprint $table) {
            $table->dropIndex(['empresa_id', 'status_implementacao']);
            $table->dropColumn(['status_implementacao', 'justificativa', 'data_revisao', 'efetividade']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('esg_indicadores', function (Blueprint $table) {
            $table->string('fonte_dado')->nullable();
            $table->foreignId('validador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('limite_organizacional', 255)->nullable();
            $table->text('metodologia')->nullable();
            $table->string('codigo_framework', 100)->nullable();
            $table->index(['empresa_id', 'dimensao', 'ativo']);
        });

        Schema::table('esg_monitoramentos', function (Blueprint $table) {
            $table->text('evidencia')->nullable();
            $table->string('status_validacao', 40)->default('pendente');
            $table->foreignId('validado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampTz('validado_em')->nullable();
            $table->unique(['esg_indicador_id', 'periodo_referencia'], 'esg_monitoramentos_indicador_periodo_unique');
        });

        Schema::table('indicadores', function (Blueprint $table) {
            $table->string('dominio', 60)->nullable();
            $table->string('tema', 120)->nullable();
            $table->string('fonte_dado')->nullable();
            $table->decimal('meta_minima', 12, 4)->nullable();
            $table->decimal('meta_maxima', 12, 4)->nullable();
            $table->foreignId('aprovador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->index(['empresa_id', 'dominio', 'ativo']);
        });

        Schema::table('monitoramentos', function (Blueprint $table) {
            $table->text('evidencia')->nullable();
            $table->string('status_validacao', 40)->default('pendente');
            $table->foreignId('validado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampTz('validado_em')->nullable();
            $table->unique(['indicador_id', 'periodo_referencia'], 'monitoramentos_indicador_periodo_unique');
        });
    }

    public function down(): void
    {
        Schema::table('monitoramentos', function (Blueprint $table) {
            $table->dropUnique('monitoramentos_indicador_periodo_unique');
            $table->dropForeign(['validado_por']);
            $table->dropColumn(['evidencia', 'status_validacao', 'validado_por', 'validado_em']);
        });

        Schema::table('indicadores', function (Blueprint $table) {
            $table->dropForeign(['aprovador_id']);
            $table->dropColumn(['dominio', 'tema', 'fonte_dado', 'meta_minima', 'meta_maxima', 'aprovador_id']);
        });

        Schema::table('esg_monitoramentos', function (Blueprint $table) {
            $table->dropUnique('esg_monitoramentos_indicador_periodo_unique');
            $table->dropForeign(['validado_por']);
            $table->dropColumn(['evidencia', 'status_validacao', 'validado_por', 'validado_em']);
        });

        Schema::table('esg_indicadores', function (Blueprint $table) {
            $table->dropIndex(['empresa_id', 'dimensao', 'ativo']);
            $table->dropForeign(['validador_id']);
            $table->dropColumn(['fonte_dado', 'validador_id', 'limite_organizacional', 'metodologia', 'codigo_framework']);
        });
    }
};

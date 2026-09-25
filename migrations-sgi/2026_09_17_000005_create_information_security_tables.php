<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('riscos_seguranca_informacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->foreignId('ativo_id')->nullable()->constrained('ativos_informacao')->nullOnDelete();
            $table->foreignId('processo_id')->nullable()->constrained('processos')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('ameaca');
            $table->text('vulnerabilidade')->nullable();
            $table->text('impacto')->nullable();
            $table->unsignedSmallInteger('probabilidade')->nullable();
            $table->unsignedSmallInteger('impacto_nivel')->nullable();
            $table->unsignedSmallInteger('nivel_risco')->nullable();
            $table->string('tratamento', 40)->nullable();
            $table->string('status', 40)->default('aberto');
            $table->date('prazo')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'status', 'nivel_risco']);
        });

        Schema::create('declaracoes_aplicabilidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->string('versao', 40);
            $table->date('data_referencia')->nullable();
            $table->string('status', 40)->default('rascunho');
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('observacao')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->unique(['empresa_id', 'versao']);
        });

        Schema::create('declaracao_aplicabilidade_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaracao_aplicabilidade_id')->constrained('declaracoes_aplicabilidade')->cascadeOnDelete();
            $table->foreignId('controle_id')->constrained('controles_seguranca')->restrictOnDelete();
            $table->boolean('aplicavel')->default(true);
            $table->string('status_implementacao', 50)->default('nao_iniciado');
            $table->text('justificativa')->nullable();
            $table->text('evidencia')->nullable();
            $table->date('data_revisao')->nullable();
            $table->foreignId('avaliado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->unique(['declaracao_aplicabilidade_id', 'controle_id']);
        });

        Schema::create('revisoes_acesso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->foreignId('usuario_id')->constrained('users')->restrictOnDelete();
            $table->foreignId('revisor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('data_revisao');
            $table->string('resultado', 40)->default('pendente');
            $table->text('justificativa')->nullable();
            $table->date('proxima_revisao')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'usuario_id', 'resultado']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('revisoes_acesso');
        Schema::dropIfExists('declaracao_aplicabilidade_itens');
        Schema::dropIfExists('declaracoes_aplicabilidade');
        Schema::dropIfExists('riscos_seguranca_informacao');
    }
};

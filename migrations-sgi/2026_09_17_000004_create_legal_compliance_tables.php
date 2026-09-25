<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avaliacoes_requisitos_legais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registro_legal_id')->constrained('registros_legais')->restrictOnDelete();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->foreignId('processo_id')->nullable()->constrained('processos')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('data_avaliacao');
            $table->string('status_atendimento', 40)->default('em_avaliacao');
            $table->text('evidencia')->nullable();
            $table->text('observacao')->nullable();
            $table->date('proxima_avaliacao')->nullable();
            $table->foreignId('acao_id')->nullable()->constrained('acoes')->nullOnDelete();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'status_atendimento', 'proxima_avaliacao']);
        });

        Schema::create('licencas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->string('tipo', 120);
            $table->string('numero', 120)->nullable();
            $table->string('orgao_emissor', 255)->nullable();
            $table->date('data_emissao')->nullable();
            $table->date('data_validade')->nullable();
            $table->string('status', 40)->default('vigente');
            $table->text('observacao')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'status', 'data_validade']);
        });

        Schema::create('condicionantes_licenca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('licenca_id')->constrained('licencas')->restrictOnDelete();
            $table->string('codigo', 80)->nullable();
            $table->text('descricao');
            $table->date('prazo')->nullable();
            $table->string('status', 40)->default('aberta');
            $table->text('evidencia')->nullable();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['licenca_id', 'status', 'prazo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('condicionantes_licenca');
        Schema::dropIfExists('licencas');
        Schema::dropIfExists('avaliacoes_requisitos_legais');
    }
};

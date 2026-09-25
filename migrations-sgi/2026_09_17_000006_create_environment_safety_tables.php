<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspecoes_ambientais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->foreignId('processo_id')->nullable()->constrained('processos')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('data_inspecao');
            $table->string('tipo', 100);
            $table->string('status', 40)->default('aberta');
            $table->text('resultado')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'status', 'data_inspecao']);
        });

        Schema::create('inspecoes_sst', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->foreignId('processo_id')->nullable()->constrained('processos')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('data_inspecao');
            $table->string('tipo', 100);
            $table->string('status', 40)->default('aberta');
            $table->text('resultado')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'status', 'data_inspecao']);
        });

        Schema::create('permissoes_trabalho', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->foreignId('processo_id')->nullable()->constrained('processos')->nullOnDelete();
            $table->foreignId('solicitante_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('aprovador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tipo', 100);
            $table->text('descricao');
            $table->dateTimeTz('inicio')->nullable();
            $table->dateTimeTz('fim')->nullable();
            $table->string('status', 40)->default('solicitada');
            $table->text('medidas_controle')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'status', 'fim']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('permissoes_trabalho');
        Schema::dropIfExists('inspecoes_sst');
        Schema::dropIfExists('inspecoes_ambientais');
    }
};

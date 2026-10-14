<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('esg_relatorios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('titulo'); // Ex: Relatório Anual de Sustentabilidade 2025
            $table->enum('framework', ['GRI', 'SASB', 'TCFD', 'Global Compact', 'Outro']);
            $table->integer('ano_referencia');
            $table->enum('status', ['Rascunho', 'Em Revisão', 'Auditado', 'Publicado'])->default('Rascunho');
            $table->date('data_publicacao')->nullable();
            $table->text('arquivo_path')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'ano_referencia']);
            $table->index('framework');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esg_relatorios');
    }
};

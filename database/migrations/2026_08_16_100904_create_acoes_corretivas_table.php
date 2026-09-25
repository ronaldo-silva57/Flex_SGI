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
        Schema::create('acoes_corretivas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nao_conformidade_id')
                ->constrained('nao_conformidades')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->enum('etapa', ['Contenção', 'Causa raiz', 'Correção', 'Verificação', 'Conclusão']);
            $table->text('descricao');
            $table->date('prazo')->nullable();
            $table->date('data_execucao')->nullable();
            $table->boolean('eficaz')->nullable();
            $table->text('evidencia')->nullable();
            $table->enum('status', ['Pendente', 'Em andamento', 'Concluída', 'Reprovada'])->default('Pendente');
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('nao_conformidade_id');
            $table->index('responsavel_id');
            $table->index('status');
            $table->index('etapa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acoes_corretivas');
    }
};

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
        Schema::create('projeto_tarefas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('projeto_id')
                ->constrained('projetos')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            
            $table->string('titulo');
            $table->text('descricao')->nullable();
            // Etapas do Kanban
            $table->enum('status_kanban', ['A Fazer', 'Em Progresso', 'Em Revisão', 'Concluído'])->default('A Fazer');
            $table->enum('prioridade', ['Baixa', 'Média', 'Alta', 'Urgente'])->default('Média');
            $table->date('data_inicio')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->integer('ordem')->default(0); // Para ordenação no Kanban
            
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['projeto_id', 'status_kanban']);
            $table->index('responsavel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projeto_tarefas');
    }
};

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
        Schema::create('planos_acao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();

            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            
            // Relacionamento Polimórfico (Origem da ação: RNC, Risco, Auditoria, Reunião, etc.)
            $table->nullableMorphs('origem');

            $table->string('codigo', 50)->nullable();
            $table->string('titulo');
            
            // Metodologia 5W2H
            $table->text('o_que')->comment('What: O que será feito');
            $table->text('por_que')->nullable()->comment('Why: Por que será feito');
            $table->text('onde')->nullable()->comment('Where: Onde será executado');
            $table->text('como')->nullable()->comment('How: Como será feito');
            $table->decimal('quanto_custa', 12, 2)->default(0.00)->comment('How much: Custo estimado');
            
            $table->date('prazo_inicio')->nullable();
            $table->date('prazo_fim')->nullable();
            $table->date('data_conclusao')->nullable();
            
            $table->unsignedTinyInteger('progresso')->default(0); // 0 a 100%
            $table->enum('status', ['Pendente', 'Em andamento', 'Em verificação', 'Concluído', 'Cancelado'])->default('Pendente');
            $table->boolean('eficaz')->nullable();
            $table->text('evidencia_conclusao')->nullable();
            $table->text('observacoes')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'status']);
            $table->index('prazo_fim');
            $table->index('responsavel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('planos_acao');
    }
};
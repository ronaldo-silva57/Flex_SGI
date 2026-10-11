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
        Schema::create('auditorias_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auditoria_id')
                ->constrained('auditorias')
                ->cascadeOnDelete();
            $table->foreignId('clausula_id')
                ->nullable()
                ->constrained('clausulas')
                ->nullOnDelete();
            $table->foreignId('processo_id')
                ->nullable()
                ->constrained('processos')
                ->nullOnDelete();
            $table->foreignId('auditor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->text('descricao_verificacao');
            $table->text('evidencia_coletada')->nullable();
            $table->enum('conformidade', ['conforme', 'nao_conforme', 'oportunidade_melhoria', 'nao_aplicavel'])->nullable();
            $table->text('observacoes')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('auditoria_id');
            $table->index('clausula_id');
            $table->index('processo_id');
            $table->index('auditor_id');
            $table->index('conformidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias_itens');
    }
};

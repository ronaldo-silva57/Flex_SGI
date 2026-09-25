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
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('norma_id')
                ->nullable()
                ->constrained('normas')
                ->nullOnDelete();
            $table->foreignId('auditor_lider_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->enum('tipo', ['Interna', 'Externa', 'Terceira parte']);
            $table->text('escopo')->nullable();
            $table->text('objetivo')->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->enum('status', ['Planejada', 'Em andamento', 'Concluída', 'Cancelada'])->default('Planejada');
            $table->text('relatorio')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('norma_id');
            $table->index('auditor_lider_id');
            $table->index('status');
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};

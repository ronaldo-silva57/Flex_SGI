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
        Schema::create('inspecoes_seguranca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('processo_id')
                ->nullable()
                ->constrained('processos')
                ->nullOnDelete();
            
            $table->string('codigo', 50);
            $table->string('titulo');
            $table->enum('tipo', ['Rotina', 'Periódica', 'Extraordinária', 'Pré-uso'])->default('Rotina');
            $table->string('local_inspecionado', 255)->nullable();
            $table->date('data_inspecao');
            $table->text('observacoes')->nullable();
            $table->enum('resultado', ['Conforme', 'Não conforme', 'Parcialmente conforme'])->nullable();
            $table->enum('status', ['Planejada', 'Realizada', 'Cancelada'])->default('Planejada');
            $table->timestampsTz();
            $table->softDeletes();

            $table->unique(['empresa_id', 'codigo']);
            $table->index(['empresa_id', 'status']);
            $table->index('data_inspecao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecoes_seguranca');
    }
};

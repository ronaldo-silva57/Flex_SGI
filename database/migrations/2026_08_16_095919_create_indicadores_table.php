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
        Schema::create('indicadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('processo_id')
                ->nullable()
                ->constrained('processos')
                ->nullOnDelete();
            $table->foreignId('norma_id')
                ->nullable()
                ->constrained('normas')
                ->nullOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('codigo', 50);
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->text('formula')->nullable();
            $table->decimal('meta', 10, 2)->nullable();
            $table->string('unidade_medida', 50)->nullable();
            $table->enum('frequencia', ['Diária', 'Semanal', 'Mensal', 'Trimestral', 'Semestral', 'Anual'])->nullable();
            $table->enum('tipo_meta', ['Maior que', 'Menor que', 'Igual a', 'Entre'])->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('processo_id');
            $table->index('norma_id');
            $table->index('responsavel_id');
            $table->index('codigo');
            $table->index('ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicadores');
    }
};

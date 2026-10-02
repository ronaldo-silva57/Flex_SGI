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
        Schema::create('equipamentos_medicao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('codigo', 50);
            $table->string('nome');
            $table->string('marca', 100)->nullable();
            $table->string('modelo', '100')->nullable();
            $table->string('numero_serie', 100)->nullable();
            $table->string('faixa_medicao', 100)->nullable();
            $table->string('resolucao', 50)->nullable();
            $table->string('localizacao', 255)->nullable();
            $table->integer('periodicidade_calibracao_meses')->nullable();
            $table->date('ultima_calibracao')->nullable();
            $table->date('proxima_calibracao')->nullable();
            $table->enum('status', ['Ativo', 'Em manutenção', 'Inativo', 'Descartado'])->default('Ativo');
            $table->timestampsTz();
            $table->softDeletes();

            $table->unique(['empresa_id', 'codigo']);
            $table->index(['empresa_id', 'status']);
            $table->index('proxima_calibracao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipamentos_medicao');
    }
};

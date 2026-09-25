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
        Schema::create('materialidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('esg_indicador_id')
                ->nullable()
                ->constrained('esg_indicadores')
                ->nullOnDelete();
            $table->string('tema');
            $table->tinyInteger('importancia_stakeholders')
            ->check('importancia_stakeholders BETWEEN 1 AND 5');
            $table->tinyInteger('importancia_negocio')
            ->check('importancia_negocio BETWEEN 1 AND 5');
            $table->integer('score')
                ->storedAs('importancia_stakeholders + importancia_negocio');
            $table->enum('classificacao', ['Baixa', 'Média', 'Alta', 'Crítica'])->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('tema');
            $table->index('score');
            $table->index('classificacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materialidade');
    }
};

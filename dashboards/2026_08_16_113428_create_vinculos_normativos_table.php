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
        Schema::create('vinculos_normativos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('norma_id')
                ->constrained('normas')
                ->cascadeOnDelete();
            $table->foreignId('clausula_id')
                ->constrained('clausulas')
                ->cascadeOnDelete();
            $table->foreignId('processo_id')
                ->constrained('processos')
                ->cascadeOnDelete();
            $table->foreignId('documento_id')
                ->nullable()
                ->constrained('documentos')
                ->nullOnDelete();
            $table->foreignId('indicador_id')
                ->nullable()
                ->constrained('indicadores')
                ->nullOnDelete();
            $table->foreignId('risco_id')
                ->nullable()
                ->constrained('riscos_oportunidades')
                ->nullOnDelete();
            $table->foreignId('requisito_legal_id')
                ->nullable()
                ->constrained('registros_legais')
                ->nullOnDelete();
            $table->foreignId('esg_indicador_id')
                ->nullable()
                ->constrained('esg_indicadores')
                ->nullOnDelete();
            $table->text('observacao')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['norma_id', 'clausula_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vinculos_normativos');
    }
};

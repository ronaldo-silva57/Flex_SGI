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
        Schema::create('controles_seguranca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('ativo_id')
                ->nullable()
                ->constrained('ativos_informacao')->nullOnDelete();
            $table->string('codigo_anexo_a', 20)->nullable();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->boolean('implementado')->default(false);
            $table->text('evidencia')->nullable();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->date('data_implementacao')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('codigo_anexo_a');
            $table->index('implementado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('controles_seguranca');
    }
};

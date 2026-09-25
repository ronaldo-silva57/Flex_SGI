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
        Schema::create('registros_legais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('norma_id')
                ->nullable()
                ->constrained('normas')
                ->nullOnDelete();
            $table->string('numero', 100)->nullable();
            $table->string('orgao')->nullable();
            $table->text('descricao');
            $table->enum('tipo', ['Lei', 'Decreto', 'Normativa', 'Convênio', 'Resolução']);
            $table->date('data_publicacao')->nullable();
            $table->date('data_vigencia')->nullable();
            $table->enum('status', ['Vigente', 'Revogado', 'Em revisão'])->default('Vigente');
            $table->string('arquivo_path', 500)->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('norma_id');
            $table->index('tipo');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_legais');
    }
};

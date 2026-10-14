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
        Schema::create('esg_indicadores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->enum('dimensao', ['Ambiental', 'Social', 'Governança']);
            $table->string('codigo', 50);
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->text('formula')->nullable();
            $table->decimal('meta', 10, 2)->nullable();
            $table->string('unidade_medida', 50)->nullable();
            $table->enum('frequencia', ['Mensal', 'Trimestral', 'Semestral', 'Anual']);
            $table->string('referencia_gri', 50)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('dimensao');
            $table->index('codigo');
            $table->index('frequencia');
            $table->index('ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esg_indicadores');
    }
};

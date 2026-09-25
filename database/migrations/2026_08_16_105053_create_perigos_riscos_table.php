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
        Schema::create('perigos_riscos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('processo_id')
                ->nullable()
                ->constrained('processos')
                ->nullOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->text('descricao_perigo');
            $table->text('risco_associado')->nullable();
            $table->text('exposicao')->nullable();
            $table->tinyInteger('probabilidade')->nullable()->check('probabilidade BETWEEN 1 AND 5');
            $table->tinyInteger('severidade')->nullable()->check('severidade BETWEEN 1 AND 5');
            $table->integer('nivel_risco')->nullable()->storedAs('probabilidade * severidade');
            $table->text('medida_controle')->nullable();
            $table->boolean('necessita_acao')->default(false);
            $table->enum('status', ['Ativo', 'Eliminado', 'Em tratamento'])->default('ativo');
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perigos_riscos');
    }
};

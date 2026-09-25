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
        Schema::create('documentos', function (Blueprint $table) {
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
            $table->string('titulo');
            $table->enum('tipo', ['Política', 'Procedimento', 'Instrução', 'Registro', 'Formulário', 'Manual', 'Outro']);
            $table->string('versao', 10)->default('1.0');
            $table->text('conteudo')->nullable();
            $table->string('arquivo_path', 500)->nullable();
            $table->enum('status', ['Rascunho', 'Em revisão', 'Aprovado', 'Obsoleto'])->default('Rascunho');
            $table->date('data_aprovacao')->nullable();
            $table->date('data_revisao')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('processo_id');
            $table->index('norma_id');
            $table->index('responsavel_id');
            $table->index('codigo');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};

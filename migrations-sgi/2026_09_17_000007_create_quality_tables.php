<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->string('nome');
            $table->string('documento', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('telefone', 40)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'ativo']);
        });

        Schema::create('reclamacoes_clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('data_reclamacao');
            $table->string('categoria', 100)->nullable();
            $table->text('descricao');
            $table->string('gravidade', 30)->default('media');
            $table->string('status', 40)->default('aberta');
            $table->date('prazo_resposta')->nullable();
            $table->date('data_encerramento')->nullable();
            $table->text('resposta')->nullable();
            $table->foreignId('acao_id')->nullable()->constrained('acoes')->nullOnDelete();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'status', 'prazo_resposta']);
        });

        Schema::create('avaliacoes_fornecedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->foreignId('fornecedor_id')->constrained('fornecedores')->restrictOnDelete();
            $table->foreignId('avaliador_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('data_avaliacao');
            $table->unsignedSmallInteger('nota')->nullable();
            $table->string('resultado', 40)->nullable();
            $table->text('criterios')->nullable();
            $table->text('observacao')->nullable();
            $table->date('proxima_avaliacao')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'fornecedor_id', 'data_avaliacao']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avaliacoes_fornecedores');
        Schema::dropIfExists('reclamacoes_clientes');
        Schema::dropIfExists('clientes');
    }
};

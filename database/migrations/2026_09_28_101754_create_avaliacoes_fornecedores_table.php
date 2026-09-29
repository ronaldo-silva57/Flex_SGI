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
        Schema::create('avaliacoes_fornecedores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('fornecedor_id')->constrained('fornecedores')->cascadeOnDelete();
            $table->foreignId('avaliador_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('periodo_referencia', 20); // Ex: 2026-Q3 ou 2026-09
            $table->decimal('nota_qualidade', 5, 2)->nullable()->comment('Nota de 0 a 100 ou 0 a 10');
            $table->decimal('nota_prazo', 5, 2)->nullable();
            $table->decimal('nota_atendimento', 5, 2)->nullable();
            $table->decimal('nota_esg_ambiental', 5, 2)->nullable();
            $table->decimal('nota_final', 5, 2)->nullable();

            $table->enum('status_qualificacao', ['Aprovado', 'Aprovado com Restrição', 'Reprovado', 'Em observação'])->default('Aprovado');
            $table->text('observacoes')->nullable();
            $table->text('plano_acao_exigido')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'fornecedor_id']);
            $table->index('status_qualificacao');
            $table->index('periodo_referencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avaliacoes_fornecedores');
    }
};
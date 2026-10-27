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
        Schema::create('esg_fornecedores_due_diligence', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            //Vinculado ao stakeholders
            $table->foreignId('stakeholder_id')
                ->nullable()
                ->constrained('stakeholders')
                ->nullOnDelete();
            $table->string('nome_fornecedor');  
            $table->string('cnpj_fornecedor', 20)->nullable();
            $table->enum('nivel_risco', ['Baixo', 'Médio', 'Alto', 'Crítico'])->default('Baixo');
            $table->date('data_avaliacao');
            $table->boolean('possui_politica_anticorrupcao')->default(false);
            $table->boolean('possui_trabalho_infantil_analise')->default(false);
            $table->text('parecer_esg')->nullable();
            $table->enum('status_aprovacao', ['Aprovado', 'Aprovado com Ressalvas', 'Reprovado', 'Em Análise'])->default('Em Análise');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'status_aprovacao']);
            $table->index('nivel_risco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esg_fornecedores_due_diligence');
    }
};

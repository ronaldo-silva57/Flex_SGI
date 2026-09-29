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
        Schema::create('mudancas_gestao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('solicitante_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('responsavel_aprovacao_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('processo_id')->nullable()->constrained('processos')->nullOnDelete();

            $table->string('codigo', 50);
            $table->string('titulo');
            $table->enum('tipo', ['Processo', 'Equipamento', 'Layout', 'Documento', 'Pessoas/Estrutura', 'Sistema/IT', 'Outros']);
            $table->text('descricao_mudanca');
            $table->text('justificativa');
            
            // Avaliações de Impacto do SGI
            $table->text('impacto_qualidade')->nullable();
            $table->text('impacto_ambiental')->nullable();
            $table->text('impacto_sso')->nullable();
            $table->text('impacto_seguranca_informacao')->nullable();

            $table->date('data_prevista');
            $table->date('data_implementacao')->nullable();
            $table->enum('status', ['Proposta', 'Em analise', 'Aprovada', 'Rejeitada', 'Em implementação', 'Concluída', 'Cancelada'])->default('Proposta');
            $table->text('parecer_aprovacao')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            $table->unique(['empresa_id', 'codigo']);
            $table->index(['empresa_id', 'status']);
            $table->index('solicitante_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mudancas_gestao');
    }
};
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
        Schema::create('nao_conformidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->restrictOnDelete();
                $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->nullOnDelete();
            $table->foreignId('norma_id')
                ->nullable()
                ->constrained('normas')
                ->nullOnDelete();
            $table->foreignId('clausula_id')
                ->nullable()
                ->constrained('clausulas')
                ->nullOnDelete();
            $table->foreignId('processo_id')
                ->nullable()
                ->constrained('processos')
                ->nullOnDelete();
            $table->foreignId('responsavel_apuracao_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('responsavel_tratamento_id')
                ->constrained('users')
                ->nullOnDelete();

            //Identificador amigável, por exemplo: NC-2026-0001
            $table->string('codigo', 40);
            $table->string('titulo', 255);

            $table->string('tipo', 40)->default('Não Conformidade');
            $table->enum('origem', ['Auditoria', 'Monitoramento', 'Reclamacao', 'Incidente', 'Outros']);
            $table->string('local_ocorrencia', 255)->nullable();

            $table->text('descricao');
            $table->text('requisito_nao_atendido')->nullable();
            $table->text('evidencia_inicial')->nullable();
            $table->enum('gravidade', ['Baixa', 'Media', 'Alta', 'Crítica'])->nullable();

            $table->string('probabilidade', 20)->nullable();
            $table->string('prioridade', 20)->nullable();
            $table->boolean('recorrente')->default(false);

            $table->enum('status', ['Aberta', 'Em analise', 'Em ação', 'Verificação', 'Fechada'])->default('Aberta');

            $table->date('data_identificacao')->nullable();
            $table->date('data_abertura')->useCurrent();
            $table->date('prazo_tratamento')->nullable();
            $table->date('data_analise')->nullable();
            $table->date('data_verificacao')->nullable();
            $table->date('data_encerramento')->nullable();

            $table->text('justificativa_encerramento')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            //O código é único da empresa, não globalmente
            $table->unique(['empresa_id', 'codigo']);

            $table->index(['empresa_id', 'status']);
            $table->index(['empresa_id', 'origem']);
            $table->index(['empresa_id', 'gravidade']);
            $table->index(['empresa_id', 'prioridade']);
            $table->index('cliente_id');
            $table->index('norma_id');
            $table->index('clausula_id');
            $table->index('processo_id');
            $table->index('prazo_tratamento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nao_conformidades');
    }
};

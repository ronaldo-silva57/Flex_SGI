<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('nao_conformidades_ambientais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->foreignId('licenca_ambiental_id')->nullable()
                  ->constrained('licencas_ambientais')->nullOnDelete();
            $table->foreignId('aspecto_ambiental_id')->nullable()
                  ->constrained('aspectos_ambientais')->nullOnDelete();
            $table->foreignId('processo_id')->nullable()->constrained('processos')->nullOnDelete();
            $table->foreignId('responsavel_apuracao_id')->nullable()
                  ->constrained('users')->nullOnDelete();
            $table->foreignId('responsavel_tratamento_id')->nullable()
                  ->constrained('users')->nullOnDelete();

            $table->string('codigo', 40);
            $table->string('titulo');
            $table->enum('origem', [
                'Auditoria','Fiscalização','Monitoramento','Reclamação','Incidente','Outros'
            ]);
            $table->string('local_ocorrencia', 255)->nullable();
            $table->text('descricao');
            $table->text('requisito_nao_atendido')->nullable();
            $table->text('evidencia_inicial')->nullable();
            $table->enum('gravidade', ['Baixa','Média','Alta','Crítica'])->nullable();
            $table->string('probabilidade', 20)->nullable();
            $table->string('prioridade', 20)->nullable();
            $table->boolean('recorrente')->default(false);
            $table->enum('status', ['Aberta','Em análise','Em ação','Verificação','Fechada'])
                  ->default('Aberta');

            $table->date('data_identificacao')->nullable();
            $table->date('data_abertura')->default(DB::raw('CURRENT_DATE'));
            $table->date('prazo_tratamento')->nullable();
            $table->date('data_analise')->nullable();
            $table->date('data_verificacao')->nullable();
            $table->date('data_encerramento')->nullable();
            $table->text('justificativa_encerramento')->nullable();
            $table->text('acao_corretiva')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            $table->unique(['empresa_id','codigo']);
            $table->index(['empresa_id','status']);
            $table->index(['empresa_id','gravidade']);
            $table->index(['empresa_id','origem']);
            $table->index('prazo_tratamento');
            $table->index('licenca_ambiental_id');
            $table->index('aspecto_ambiental_id');
            $table->index('processo_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nao_conformidades_ambientais');
    }
};
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emergencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('titulo');
            $table->enum('tipo', [
                'Incêndio','Vazamento Químico','Derramamento','Explosão',
                'Deslizamento','Enchente','Vazamento de Gás','Outros'
            ]);
            $table->text('descricao');
            $table->string('localizacao', 255)->nullable();
            $table->timestamp('data_ocorrencia')->nullable();
            $table->timestamp('data_encerramento')->nullable();
            $table->enum('gravidade', ['Baixa','Média','Alta','Crítica'])->nullable();
            $table->text('causas')->nullable();
            $table->text('impactos_ambientais')->nullable();
            $table->text('acoes_imediatas')->nullable();
            $table->text('acoes_corretivas')->nullable();
            $table->text('plano_emergencia')->nullable();
            $table->integer('simulados_realizados')->default(0);
            $table->date('data_ultimo_simulado')->nullable();
            $table->enum('status', ['Aberto','Em atendimento','Controlado','Encerrado'])
                  ->default('Aberto');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id','status']);
            $table->index('tipo');
            $table->index('data_ocorrencia');
            $table->index('gravidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergencias');
    }
};
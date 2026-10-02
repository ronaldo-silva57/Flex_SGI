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
        Schema::create('indicadores_ambientais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('codigo', 50);
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->enum('categoria', [
                'Emissões Atmosféricas','Recursos Hídricos','Energia','Resíduos',
                'Biodiversidade','Uso do Solo','Ruído','Outros'
            ]);
            $table->text('formula')->nullable();
            $table->decimal('meta', 12, 2)->nullable();
            $table->string('unidade_medida', 50)->nullable();
            $table->enum('frequencia', ['Mensal','Trimestral','Semestral','Anual'])->nullable();
            $table->enum('tipo_meta', ['Maior que','Menor que','Igual a','Entre'])->nullable();
            $table->boolean('ativo')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['empresa_id','ativo']);
            $table->index('categoria');
            $table->index('codigo');
        });

        // Tabela de leituras (segue padrão de `monitoramentos`/`esg_monitoramentos`)
        Schema::create('monitoramentos_ambientais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicador_ambiental_id')
                  ->constrained('indicadores_ambientais')->cascadeOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('periodo_referencia', 20);
            $table->decimal('valor_realizado', 12, 2)->nullable();
            $table->decimal('valor_meta', 12, 2)->nullable();
            $table->text('analise')->nullable();
            $table->text('acao_necessaria')->nullable();
            $table->enum('status', ['No prazo','Atrasado','Concluído'])->default('No prazo');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index('indicador_ambiental_id');
            $table->index('periodo_referencia');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoramentos_ambientais');
        Schema::dropIfExists('indicadores_ambientais');
    }
};
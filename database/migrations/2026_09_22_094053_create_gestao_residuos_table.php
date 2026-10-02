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
        Schema::create('gestao_residuos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('processo_id')->nullable()->constrained('processos')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('codigo', 50);
            $table->string('descricao');
            // Classes NBR 10.004
            $table->enum('classe', ['Classe I','Classe II-A','Classe II-B'])->nullable();
            $table->enum('tipo', ['Reciclável','Não reciclável','Perigoso','Inerte','Orgânico','Outros']);
            $table->string('fonte_geradora', 255)->nullable();
            $table->decimal('quantidade_gerada', 12, 3)->nullable();
            $table->string('unidade_medida', 20)->nullable();
            $table->enum('frequencia_geracao', ['Diária','Semanal','Mensal','Trimestral','Semestral','Anual','Esporádica'])->nullable();
            $table->text('forma_armazenamento')->nullable();
            $table->enum('destino_final', [
                'Reutilização','Reciclagem','Coprocessamento','Aterro Industrial',
                'Aterro Sanitário','Incineração','Compostagem','Outros'
            ])->nullable();
            $table->string('transportador', 255)->nullable();
            $table->string('destinador', 255)->nullable();
            $table->string('numero_mtr', 100)->nullable();
            $table->text('observacoes')->nullable();
            $table->enum('status', ['Ativo','Inativo'])->default('Ativo');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id','status']);
            $table->index('processo_id');
            $table->index('tipo');
            $table->index('classe');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestao_residuos');
    }
};
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
        Schema::create('objetivos_ambientais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('aspecto_ambiental_id')->nullable()
                  ->constrained('aspectos_ambientais')->nullOnDelete();

            $table->string('codigo', 50);
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->string('indicador')->nullable();
            $table->decimal('meta', 12, 2)->nullable();
            $table->string('unidade_medida', 50)->nullable();
            $table->text('recursos_necessarios')->nullable();
            $table->text('responsaveis_execucao')->nullable();

            $table->date('data_inicio')->nullable();
            $table->date('prazo')->nullable();
            $table->date('data_conclusao')->nullable();
            $table->unsignedTinyInteger('progresso')->default(0); // 0..100
            $table->text('evidencia')->nullable();
            $table->enum('status', ['Planejado','Em andamento','Concluído','Cancelado','Atrasado'])
                  ->default('Planejado');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id','status']);
            $table->index('prazo');
            $table->index('responsavel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objetivos_ambientais');
    }
};
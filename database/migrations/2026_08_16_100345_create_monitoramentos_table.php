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
        Schema::create('monitoramentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicador_id')
                ->constrained('indicadores')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('periodo_referencia', 20);
            $table->decimal('valor_realizado', 10, 2)->nullable();
            $table->decimal('valor_meta', 10, 2)->nullable();
            $table->text('analise')->nullable();
            $table->text('acao_necessaria')->nullable();
            $table->enum('status', ['No prazo', 'Atrasado', 'Concluído'])->default('No prazo');
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('indicador_id');
            $table->index('responsavel_id');
            $table->index('periodo_referencia');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoramentos');
    }
};

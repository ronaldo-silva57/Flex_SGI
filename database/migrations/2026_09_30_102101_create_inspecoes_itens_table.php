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
        Schema::create('inspecoes_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inspecao_id')
                ->constrained('inspecoes_seguranca')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('item_verificado');
            $table->enum('conformidade', ['Conforme', 'Não conforme', 'Não aplicável'])->nullable();
            $table->text('evidencia')->nullable();
            $table->text('acao_necessaria')->nullable();
            $table->date('prazo')->nullable();
            $table->timestampsTz();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspecoes_itens');
    }
};

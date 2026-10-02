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
        Schema::create('calibracoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')
                ->constrained('equipamentos_medicao')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->date('data_calibracao');
            $table->date('data_validade');
            $table->string('laboratorio', 255)->nullable();
            $table->string('certificado_numero', 100)->nullable();
            $table->string('certificado_path', 500)->nullable();
            $table->enum('resultado', ['Aprovado', 'Aprovado com restrição', 'Reprovado'])->default('Aprovado');
            $table->text('observacoes')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('equipamento_id');
            $table->index('data_validade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calibracoes');
    }
};

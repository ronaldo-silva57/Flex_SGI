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
        Schema::create('comunicacoes_internas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('autor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('titulo');
            $table->text('conteudo');
            $table->enum('tipo', ['Aviso', 'Circular', 'Política SGI', 'Comunicado Oficial'])->default('Aviso');
            $table->boolean('exige_ciencia')->default(false);
            $table->dateTimeTz('publicado_em')->nullable();
            $table->dateTimeTz('expirado_em')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'ativo']);
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comunicacoes_internas');
    }
};

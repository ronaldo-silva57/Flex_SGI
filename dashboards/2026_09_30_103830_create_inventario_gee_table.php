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
        Schema::create('inventario_gee', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('codigo', 50);
            $table->integer('ano_referencia');
            $table->enum('escopo', ['1', '2', '3'])->comment('GHG Protocol');
            $table->string('categoria', 150)->nullable();       // ex:combustão móvel
            $table->string('fonte_emissao', 255);
            $table->decimal('quantidade', 15, 3)->nullable();
            $table->string('unidade', 30)->nullable();
            $table->decimal('fator_emissao', 15, 6)->nullable();
            $table->decimal('emissao_tco2e', 15, 6);            //toneladas CO2 equivalentes
            $table->text('metodologia')->nullable();
            $table->string('referencia_fator', 255)->nullable();
            $table->text('evidencia')->nullable();
            $table->enum('status', ['Rascunho', 'Em revisão', 'Verificado', 'Publicado'])->default('Rascunho');

            $table->timestampsTz();
            $table->softDeletes();

            $table->unique(['empresa_id', 'codigo']);
            $table->index(['empresa_id', 'ano_referencia']);
            $table->index('escopo');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_gee');
    }
};

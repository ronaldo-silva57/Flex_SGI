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
        Schema::create('esg_diversidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->integer('ano_referencia');
            $table->string('categoria_cargo', 100); //Ex: Diretoria, Gerência, Operacional
            $table->string('genero', 50)->nullable(); //Ex: Feminino, Masculino, Outro / Não informado
            $table->string('raca_etnia', 50)->nullable(); //Ex: Branco, Negro, Pardo, Indígena, Amarelo
            $table->integer('quantidade_colaboradores')->default(0);
            $table->boolean('cargo_lideranca')->default(false);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'ano_referencia']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esg_diversidade');
    }
};

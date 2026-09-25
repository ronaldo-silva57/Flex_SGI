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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50);
            $table->string('razao_social');
            $table->string('nome_fantasia')->nullable();
            $table->string('cnpj', 20)->nullable();
            $table->string('contato_nome')->nullable();
            $table->string('contato_email')->nullable();
            $table->string('contato_telefone', 20)->nullable();
            $table->text('endereco')->nullable();
            $table->string('categoria', 100)->nullable();
            $table->tinyInteger('avaliacao_risco')->nullable()->check('avaliacao_risco BETWEEN 1 AND 5');
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('cnpj');
            $table->index('ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fonecedores');
    }
};

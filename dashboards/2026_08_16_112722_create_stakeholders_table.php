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
        Schema::create('stakeholders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->string('nome');
            $table->enum('tipo', ['Cliente', 'Colaborador', 'Fornecedor', 'Comunidade', 'Investidor', 'Governo', 'Outros']);
            $table->string('contato')->nullable();
            $table->text('expectativas')->nullable();
            $table->text('necessidades')->nullable();
            $table->tinyInteger('prioridade')->nullable()->check('prioridade BETWEEN 1 AND 5');
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('tipo');
            $table->index('prioridade');
            $table->index('ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stakeholders');
    }
};

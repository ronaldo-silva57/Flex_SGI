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
        Schema::create('competencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->string('codigo', 50)->nullable();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['Técnica', 'Comportamental', 'Certificação', 'Treinamento'])->default('Técnica');
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'ativo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competencias');
    }
};

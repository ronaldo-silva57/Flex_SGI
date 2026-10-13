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
        Schema::create('cargos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('departamento_id')
                ->nullable()
                ->constrained('departamentos')
                ->nullOnDelete();
            $table->string('codigo', 50)->nullable();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->text('requisitos')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'ativo']);
            $table->index('departamento_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos');
    }
};

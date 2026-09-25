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
        Schema::create('epis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->string('categoria', 100)->nullable();
            $table->string('ca', 50)->nullable();
            $table->integer('validade_meses')->nullable();
            $table->integer('estoque_minimo')->nullable();
            $table->integer('estoque_atual')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('categoria');
            $table->index('ativo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epis');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\text;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clausulas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('norma_id')
                ->constrained('normas')
                ->restrictOnDelete();
            $table->string('codigo', 20);
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->foreignId('clausula_pai_id')
                ->nullable()
                ->constrained('clausulas')
                ->nullOnDelete();
            $table->integer('ordem')->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('norma_id');
            $table->index('ativo');
            $table->unique(['norma_id', 'codigo']);
            $table->index('descricao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clausulas');
    }
};

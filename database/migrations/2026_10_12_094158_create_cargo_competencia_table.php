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
        Schema::create('cargo_competencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cargo_id')
                ->constrained('cargos')
                ->cascadeOnDelete();
            $table->foreignId('competencia_id')
                ->constrained('competencias')
                ->cascadeOnDelete();
            $table->string('nivel_exigido', 50)->nullable(); // Ex.: Básico, Intermediário, Avançado
            $table->timestampsTz();
            $table->softDeletes();

            $table->unique(['cargo_id', 'competencia_id'], 'cargo_competencia_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargo_competencia');
    }
};

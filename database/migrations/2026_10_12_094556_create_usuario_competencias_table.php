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
        Schema::create('usuario_competencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('competencia_id')
                ->constrained('competencias')
                ->cascadeOnDelete();
            $table->string('nivel_atual', 50)->nullable();
            $table->date('data_obtencao')->nullable();
            $table->date('validade')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->unique(['user_id', 'competencia_id'], 'user_competencia_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_competencias');
    }
};

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
        Schema::create('analises_causa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nao_conformidade_id')
                ->constrained('nao_conformidades')
                ->nullOnDelete();

            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('metodo', 40);
            $table->string('status', 30)->default('Em andamento');

            $table->text('objetivo')->nullable();
            $table->text('conclusao')->nullable();

            $table->date('data_inicio')->nullable();
            $table->date('data_conclusao')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['nao_conformidade_id', 'metodo']);
            $table->index(['nao_conformidade_id', 'status']);
            $table->index('responsavel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analises_causa');
    }
};

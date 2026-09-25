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
        Schema::create('analise_causa_respostas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('analise_causa_id')
                ->constrained('analises_causa')
                ->nullOnDelete();

            //1, 2, 3, 4, 5
            $table->unsignedSmallInteger('ordem');
            $table->string('pergunta', 255);
            $table->text('resposta');
            $table->text('evidencia')->nullable();
            $table->boolean('eh_causa_raiz')->default(false);
            $table->timestampsTz();
            $table->softDeletes();

            $table->unique(['analise_causa_id', 'ordem']);
            $table->index('analise_causa_id');
            $table->index(['analise_causa_id', 'eh_causa_raiz']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analise_causa_respostas');
    }
};

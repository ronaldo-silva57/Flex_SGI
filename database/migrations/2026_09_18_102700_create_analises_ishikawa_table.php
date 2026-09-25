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
        Schema::create('analises_ishikawa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('analise_causa_id')
                ->constrained('analises_causa')
                ->nullOnDelete();
            $table->foreignId('responsavel_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->string('efeito_analisado', 255);
            $table->text('conclusao')->nullable();

            $table->date('data_inicio')->nullable();
            $table->date('data_conclusao')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            $table->index('analise_causa_id');
            $table->index('responsavel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analises_ishikawa');
    }
};

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
        Schema::create('documento_revisoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')
                ->constrained('documentos')
                ->cascadeOnDelete();
            $table->string('versao', 20);
            $table->text('alteracoes_realizadas');
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('arquivo_path', 500)->nullable();
            $table->timestampTz('data_revisao')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('documento_id');
            $table->index('versao');

            $table->unique(['documento_id', 'versao']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_revisoes');
    }
};

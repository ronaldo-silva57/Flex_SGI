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
        Schema::create('comunicacao_leituras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comunicacao_id')
                ->constrained('comunicacoes_internas')
                ->cascadeOnDelete();
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamp('lido_em')->useCurrent();

            $table->unique(['comunicacao_id', 'user_id'], 'comunicacao_usuario_leitura_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comunicacao_leituras');
    }
};

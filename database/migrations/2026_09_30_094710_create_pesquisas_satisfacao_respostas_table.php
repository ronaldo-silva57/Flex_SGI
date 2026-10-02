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
        Schema::create('pesquisas_satisfacao_respostas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesquisa_id')
                ->constrained('pesquisas_satisfacao')
                ->cascadeOnDelete();
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->nullOnDelete();
            $table->foreignId('respondente_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->decimal('nota', 5, 2);
            $table->jsonb('respostas_detalhadas')->nullable();
            $table->enum('classificacao', ['Promotor', 'Neutro', 'Detrator'])->nullable();
            $table->timestamp('respondido_em')->useCurrent();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('pesquisa_id');
            $table->index('classificacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesquisas_satisfacao_respostas');
    }
};

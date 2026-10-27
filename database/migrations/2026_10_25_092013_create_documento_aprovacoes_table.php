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
        Schema::create('documento_aprovacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')
                ->constrained('documentos')
                ->cascadeOnDelete();
            $table->foreignId('aprovador_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->enum('status', ['Pendente', 'Aprovado', 'Rejeitado'])->default('Pendente');
            $table->text('observacoes')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('documento_id');
            $table->index('aprovador_id');
            $table->index('status');

            $table->unique(['documento_id', 'aprovador_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_aprovacoes');
    }
};

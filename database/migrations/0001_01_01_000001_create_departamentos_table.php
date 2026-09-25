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
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 50)->nullable();
            $table->foreignId('empresa_id')
                ->nullable()
                ->constrained('empresas')
                ->nullOnDelete();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->unsignedBigInteger('responsavel_id')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('responsavel_id');
            $table->index(['empresa_id', 'ativo']);
            $table->index('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamentos');
    }
};

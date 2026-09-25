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
        Schema::create('ativos_informacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('nome');
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['Hardware', 'Software', 'Dados', 'Servico', 'Pessoas', 'Instalações', 'Intangível']);
            $table->string('localizacao')->nullable();
            $table->foreignId('proprietario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->enum('classificacao', ['Público', 'Interno', 'Confidencial', 'Restrito'])->nullable();
            $table->decimal('valor', 10, 2)->nullable();
            $table->enum('status', ['Ativo', 'Inativo', 'Descartado'])->default('Ativo');
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('tipo');
            $table->index('classificacao');
            $table->index('status');

            $table->index('nome');
            $table->index('descricao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ativos_informacao');
    }
};

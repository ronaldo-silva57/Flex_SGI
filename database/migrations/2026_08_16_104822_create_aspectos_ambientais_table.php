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
        Schema::create('aspectos_ambientais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('processo_id')
                ->nullable()
                ->constrained('processos')
                ->nullOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->text('descricao');
            $table->enum('tipo', ['Emissao ar', 'Efluente', 'Resíduo', 'Ruído', 'Uso recurso', 'Outros']);
            $table->text('impacto_associado')->nullable();
            $table->tinyInteger('significancia')->nullable()->check('significancia BETWEEN 1 AND 5');
            $table->text('controle_existente')->nullable();
            $table->text('programa_gestao')->nullable();
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->timestamps();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('processo_id');
            $table->index('tipo');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aspectos_ambientais');
    }
};

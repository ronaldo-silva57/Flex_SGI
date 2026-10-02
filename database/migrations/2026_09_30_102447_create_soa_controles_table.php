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
        Schema::create('soa_controles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Referência ao Anexo A da ISO 27001
            $table->string('codigo_anexo_a', 20);       // ex: A.5.1
            $table->string('dominio', 100);             // ex: Políticas de SI
            $table->string('titulo');
            $table->text('descricao')->nullable();

            $table->boolean('aplicavel')->default(true);
            $table->text('justificativa_inclusao')->nullable();
            $table->text('justificativa_exclusao')->nullable();
            $table->enum('status_implementacao', ['Não iniciado', 'Em implementacao', 'Implementado'. 'Não aplicável'])->default('Não iniciado');
            $table->text('evidencia')->nullable();
            $table->foreignId('controle_id')
                ->nullable()
                ->constrained('controles_seguranca')
                ->nullOnDelete();

            $table->timestampsTz();
            $table->softDeletes();

            $table->unique(['empresa_id', 'codigo_anexo_a']);
            $table->index(['empresa_id', 'aplicavel']);
            $table->index('status_implementacao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soa_controles');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('esg_governanca_membros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();

            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('nome');
            $table->enum('orgao', ['Conselho de Administração', 'Diretoria Executiva', 'Comitê de Auditoria', 'Comitê ESG', 'Outro']);
            $table->string('cargo', 100); // Ex: Conselheiro Independente, Presidente
            $table->boolean('independente')->default(false);
            $table->date('inicio_mandato')->nullable();
            $table->date('fim_mandato')->nullable();
            $table->boolean('ativo')->default(true);

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'orgao']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('esg_governanca_membros');
    }
};
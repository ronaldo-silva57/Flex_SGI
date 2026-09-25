<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programas_auditoria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->string('nome');
            $table->unsignedSmallInteger('ano');
            $table->text('objetivo')->nullable();
            $table->string('status', 40)->default('rascunho');
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->unique(['empresa_id', 'nome', 'ano']);
        });

        Schema::create('auditoria_equipe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auditoria_id')->constrained('auditorias')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('users')->restrictOnDelete();
            $table->string('papel', 50)->default('auditor');
            $table->timestampsTz();
            $table->unique(['auditoria_id', 'usuario_id']);
        });

        Schema::create('auditoria_constatacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('auditoria_id')->constrained('auditorias')->restrictOnDelete();
            $table->foreignId('auditoria_item_id')->nullable()->constrained('auditorias_itens')->nullOnDelete();
            $table->string('tipo', 50);
            $table->string('classificacao', 50)->nullable();
            $table->text('descricao');
            $table->text('evidencia')->nullable();
            $table->foreignId('nao_conformidade_id')->nullable()->constrained('nao_conformidades')->nullOnDelete();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['auditoria_id', 'tipo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditoria_constatacoes');
        Schema::dropIfExists('auditoria_equipe');
        Schema::dropIfExists('programas_auditoria');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documento_versoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')->constrained('documentos')->restrictOnDelete();
            $table->string('numero_versao', 30);
            $table->string('titulo');
            $table->text('conteudo')->nullable();
            $table->string('arquivo_path', 500)->nullable();
            $table->string('hash_sha256', 64)->nullable();
            $table->text('motivo_alteracao')->nullable();
            $table->string('status', 40)->default('rascunho');
            $table->foreignId('criado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('publicado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampTz('aprovado_em')->nullable();
            $table->timestampTz('publicado_em')->nullable();
            $table->date('data_revisao')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->unique(['documento_id', 'numero_versao']);
            $table->index(['documento_id', 'status']);
        });

        Schema::create('documento_distribuicoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_versao_id')->constrained('documento_versoes')->cascadeOnDelete();
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('departamento_id')->nullable()->constrained('departamentos')->nullOnDelete();
            $table->timestampTz('distribuido_em')->nullable();
            $table->timestampTz('ciente_em')->nullable();
            $table->string('status', 30)->default('pendente');
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['documento_versao_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documento_distribuicoes');
        Schema::dropIfExists('documento_versoes');
    }
};

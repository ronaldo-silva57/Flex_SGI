<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anexos', function (Blueprint $table) {
            $table->id();
            $table->morphs('attachable');
            $table->foreignId('enviado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nome_original');
            $table->string('arquivo_path', 500);
            $table->string('mime_type', 150)->nullable();
            $table->unsignedBigInteger('tamanho_bytes')->nullable();
            $table->string('hash_sha256', 64)->nullable();
            $table->text('descricao')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['attachable_type', 'attachable_id', 'created_at']);
        });

        Schema::create('comentarios', function (Blueprint $table) {
            $table->id();
            $table->morphs('commentable');
            $table->foreignId('usuario_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('conteudo');
            $table->boolean('interno')->default(true);
            $table->timestampsTz();
            $table->softDeletesTz();
        });

        Schema::create('aprovacoes', function (Blueprint $table) {
            $table->id();
            $table->morphs('approvable');
            $table->foreignId('solicitado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('aprovado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->string('etapa', 80);
            $table->string('status', 40)->default('pendente');
            $table->text('observacao')->nullable();
            $table->timestampTz('solicitado_em')->nullable();
            $table->timestampTz('decidido_em')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['approvable_type', 'approvable_id', 'status']);
        });

        Schema::create('acoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            $table->nullableMorphs('source');
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('criado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->string('tipo', 60)->default('melhoria');
            $table->string('prioridade', 30)->default('media');
            $table->text('descricao');
            $table->text('resultado')->nullable();
            $table->boolean('eficaz')->nullable();
            $table->text('verificacao_eficacia')->nullable();
            $table->string('status', 40)->default('aberta');
            $table->date('prazo')->nullable();
            $table->date('data_conclusao')->nullable();
            $table->foreignId('verificado_por')->nullable()->constrained('users')->nullOnDelete();
            $table->date('data_verificacao')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();
            $table->index(['empresa_id', 'status', 'prazo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acoes');
        Schema::dropIfExists('aprovacoes');
        Schema::dropIfExists('comentarios');
        Schema::dropIfExists('anexos');
    }
};

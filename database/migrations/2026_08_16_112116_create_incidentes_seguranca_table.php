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
        Schema::create('incidentes_seguranca', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('ativo_id')
                ->nullable()
                ->constrained('ativos_informacao')
                ->nullOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('data_ocorrencia');
            $table->enum('tipo', ['Acesso não autorizado', 'Malware', 'Vazamento Dados', 'Indisponibilidade', 'Phishing', 'Outros']);
            $table->text('descricao');
            $table->text('impacto')->nullable();
            $table->text('acao_imediata')->nullable();
            $table->text('investigacao')->nullable();
            $table->enum('status', ['Aberto', 'Em investigação', 'Concluído'])->default('Aberto');
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('data_ocorrencia');
            $table->index('tipo');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidentes_seguranca');
    }
};

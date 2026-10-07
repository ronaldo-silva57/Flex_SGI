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
        Schema::create('cipa_reunioes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('presidente_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('secretario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('gestao_ano', 9)->comment('Ex: 2026/2027');
            $table->enum('tipo', ['Ordinária', 'Extraordinária', 'Inspeção de Campo', 'DDSGeral']);
            $table->date('data_reuniao');
            $table->string('pauta_principal');
            $table->text('pauta_detalhada')->nullable();
            $table->text('deliberacoes')->nullable();
            $table->string('ata_arquivo_path', 500)->nullable();
            $table->enum('status', ['Agendada', 'Realizada', 'Cancelada'])->default('Agendada');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'data_reuniao']);
            $table->index(['empresa_id', 'status']);
            $table->index(['empresa_id', 'gestao_ano']);
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cipa_reunioes');
    }
};
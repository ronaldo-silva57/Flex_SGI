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
        Schema::create('contratos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->nullOnDelete();
            $table->foreignId('fornecedor_id')
                ->nullable()
                ->constrained('fornecedores')
                ->nullOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('numero_contrato', 50);
            $table->string('titulo');
            $table->enum('tipo', ['Cliente', 'Fornecedor', 'Parceria', 'Prestação de Serviço'])->default('Cliente');
            $table->decimal('valor_total', 12, 6)->nullable();
            $table->date('data_inicio');
            $table->date('data_fim');
            $table->integer('alerta_vencimento_dias')->default(30);
            $table->enum('status', ['Minuta', 'Vingente', 'Suspenso', 'Encerrado', 'Recindido'])->default('Vigente');
            $table->text('objeto')->nullable();
            $table->text('observacoes')->nullable();
            $table->string('arquivo_path')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'status']);
            $table->index(['data_inicio', 'data_fim']);
            $table->index('cliente_id');
            $table->index('fornecedor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratos');
    }
};

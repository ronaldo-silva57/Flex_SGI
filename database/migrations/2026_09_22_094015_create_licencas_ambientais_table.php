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
        Schema::create('licencas_ambientais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('numero', 100);
            $table->enum('tipo', ['LP','LI','LO','LAC','LAS','LAU','Outros']);
            $table->string('orgao_emissor', 255);
            $table->text('descricao')->nullable();
            $table->text('condicionantes')->nullable();
            $table->date('data_emissao');
            $table->date('data_validade');
            $table->date('data_renovacao')->nullable();
            $table->string('arquivo_path', 500)->nullable();
            $table->enum('status', ['Vigente','Vencida','Em renovação','Suspensa','Cancelada'])
                  ->default('Vigente');
            $table->text('observacoes')->nullable();

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id','status']);
            $table->index('data_validade');
            $table->index('tipo');
            $table->index('responsavel_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licencas_ambientais');
    }
};

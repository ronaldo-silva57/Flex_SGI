<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->restrictOnDelete();
            
            $table->enum('tipo_documento', ['cpf', 'cnpj'])->nullable(); 
            $table->string('documento', 20)->nullable(); 
            $table->string('nome'); 
            $table->string('razao_social')->nullable(); 
            $table->string('contato_principal')->nullable(); 
            $table->string('email')->nullable();
            $table->string('telefone', 25)->nullable();
            $table->string('cidade', 100)->nullable();
            $table->char('estado', 2)->nullable();
            $table->text('endereco_completo')->nullable();
            $table->enum('status', ['ativo', 'inativo', 'bloqueado_sgi'])->default('ativo'); 
            $table->text('observacoes_compliance')->nullable();     
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'status']);
            $table->unique(['empresa_id', 'tipo_documento', 'documento'], 'uid_empresa_documento'); 
            $table->index(['cidade', 'estado']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};

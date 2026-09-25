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
            // Tenant/Empresa do grupo que gerencia este cliente
            $table->foreignId('empresa_id')->constrained('empresas')->restrictOnDelete();
            
            // Identificação do Cliente (Flexível para PF e PJ)
            $table->enum('tipo_documento', ['cpf', 'cnpj'])->nullable(); 
            $table->string('documento', 20)->nullable(); // Mantido flexível para com/sem máscara
            
            $table->string('nome'); // Nome da Pessoa Física ou Nome Fantasia da Empresa (Obrigatório para registrar a queixa)
            $table->string('razao_social')->nullable(); // Preenchido apenas se for PJ
            
            // Dados de Contato (Essenciais para o follow-up da reclamação / Planos de Ação)
            $table->string('contato_principal')->nullable(); // Nome da pessoa focal na empresa cliente
            $table->string('email')->nullable(); // Retirado o UNIQUE global para evitar conflito entre empresas diferentes (Multi-tenant)
            $table->string('telefone', 25)->nullable();
            
            // Localização Geográfica (Crucial para indicadores e relatórios de Análise Crítica da ISO 9001)
            $table->string('cidade', 100)->nullable();
            $table->char('estado', 2)->nullable();
            $table->text('endereco_completo')->nullable(); // Campo livre para histórico caso necessário

            // Governança, Compliance e Auditoria (ISO / ESG)
            $table->enum('status', ['ativo', 'inativo', 'bloqueado_sgi'])->default('ativo'); // "bloqueado_sgi" para clientes com excesso de queixas ou em auditoria
            $table->text('observacoes_compliance')->nullable(); // Notas sobre o perfil de risco do cliente, criticidade ou histórico
            
            $table->timestampsTz(); // Preserva o fuso horário (Excelente para auditoria de logs)

            // Índices Cruciais para Performance e Auditorias do SGI
            $table->index(['empresa_id', 'status']);
            $table->unique(['empresa_id', 'tipo_documento', 'documento'], 'uid_empresa_documento'); // O mesmo cliente não se duplica na mesma unidade
            $table->index(['cidade', 'estado']); // Para gerar gráficos de calor de reclamações por região
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

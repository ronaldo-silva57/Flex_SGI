<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('riscos_oportunidades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->restrictOnDelete();
            $table->foreignId('processo_id')
                ->nullable()
                ->constrained('processos')
                ->nullOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->enum('tipo', ['Risco', 'Oportunidade']);
            $table->text('descricao');
            $table->text('causa')->nullable();
            $table->text('consequencia')->nullable();
            $table->tinyInteger('probabilidade')->nullable();
            $table->tinyInteger('impacto')->nullable();
            $table->integer('nivel_risco')->nullable()->storedAs('probabilidade * impacto');
            $table->enum('tratamento', ['Eliminar', 'Mitigar', 'Transferir', 'Aceitar'])->nullable();
            $table->text('plano_acao')->nullable();
            $table->date('prazo')->nullable();
            $table->enum('status', ['Aberto', 'Em andamento', 'Concluído', 'Cancelado'])->default('Aberto');
            $table->text('evidencia')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'processo_id']);
            $table->index('responsavel_id');
            $table->index('status');
        });

    /**
     * Constraints CHECK via SQL puro
     */    
    DB::statement('ALTER TABLE riscos_oportunidades ADD CONSTRAINT check_probabilidade CHECK (probabilidade BETWEEN 1 AND 5)');
    DB::statement('ALTER TABLE riscos_oportunidades ADD CONSTRAINT check_impacto CHECK (impacto BETWEEN 1 AND 5)');       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riscos_oportunidades');
    }
};

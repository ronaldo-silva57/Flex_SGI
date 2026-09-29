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
        Schema::create('analises_risco_ti', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('ativo_id')->constrained('ativos_informacao')->cascadeOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('ameaca', 255);
            $table->string('vulnerabilidade', 255);
            
            // Pilares da Segurança Afetados
            $table->boolean('afeta_confidencialidade')->default(true);
            $table->boolean('afeta_integridade')->default(true);
            $table->boolean('afeta_disponibilidade')->default(true);

            $table->tinyInteger('probabilidade')->comment('1 a 5');
            $table->tinyInteger('impacto')->comment('1 a 5');
            $table->integer('nivel_risco_inerente')->nullable()->storedAs('probabilidade * impacto');

            $table->text('controles_existentes')->nullable();
            $table->enum('opcao_tratamento', ['Mitigar', 'Transferir', 'Evitar', 'Aceitar'])->default('Mitigar');
            $table->text('plano_tratamento')->nullable();

            $table->tinyInteger('probabilidade_residual')->nullable();
            $table->tinyInteger('impacto_residual')->nullable();
            $table->integer('nivel_risco_residual')->nullable()->storedAs('probabilidade_residual * impacto_residual');

            $table->enum('status', ['Identificado', 'Em tratamento', 'Monitorado', 'Encerrado'])->default('Identificado');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'ativo_id']);
            $table->index('status');
        });

        DB::statement('ALTER TABLE analises_risco_ti ADD CONSTRAINT check_prob_ti CHECK (probabilidade BETWEEN 1 AND 5)');
        DB::statement('ALTER TABLE analises_risco_ti ADD CONSTRAINT check_imp_ti CHECK (impacto BETWEEN 1 AND 5)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analises_risco_ti');
    }
};
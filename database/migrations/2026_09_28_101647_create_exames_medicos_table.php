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
        Schema::create('exames_medicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('usuario_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('medico_examinador_id')->nullable()->constrained('users')->nullOnDelete();

            $table->enum('tipo_aso', ['Admissional', 'Periódico', 'Retorno ao Trabalho', 'Mudança de Risco', 'Demissional']);
            $table->date('data_realizacao');
            $table->date('data_vencimento')->nullable();
            $table->enum('resultado', ['Apto', 'Apto com Restrição', 'Inapto'])->default('Apto');
            $table->text('restricoes')->nullable();
            $table->string('crm_medico', 30)->nullable();
            $table->string('medico_nome', 255)->nullable();
            $table->string('arquivo_aso_path', 500)->nullable();
            $table->enum('status', ['Vigente', 'Vencido', 'Substituído'])->default('Vigente');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'status']);
            $table->index(['usuario_id', 'status']);
            $table->index('data_vencimento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exames_medicos');
    }
};
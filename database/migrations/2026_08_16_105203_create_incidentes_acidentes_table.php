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
        Schema::create('incidentes_acidentes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('data_ocorrencia');
            $table->string('local')->nullable();
            $table->enum('tipo', ['Quase acidente', 'Incidente', 'Acidente leve', 'Acidente grave', 'Fatal']);
            $table->text('descricao');
            $table->text('causas')->nullable();
            $table->text('lesao')->nullable();
            $table->integer('dias_perdidos')->default(0);
            $table->text('tratamento')->nullable();
            $table->text('investigacao')->nullable();
            $table->text('acao_corretiva')->nullable();
            $table->enum('status', ['Aberto', 'Em investigação', 'Concluído'])->default('Aberto');
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('usuario_id');
            $table->index('tipo');
            $table->index('status');
            $table->index('data_ocorrencia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidentes_acidentes');
    }
};

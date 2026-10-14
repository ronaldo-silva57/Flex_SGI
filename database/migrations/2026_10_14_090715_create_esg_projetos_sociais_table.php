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
        Schema::create('esg_projetos_sociais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('nome_projeto');
            $table->text('descricao')->nullable();
            $table->string('localidade', 150)->nullable();
            $table->date('data_inicio')->nullable();
            $table->date('data_fim')->nullable();
            $table->decimal('orcamento_investido', 12, 6)->default(0);
            $table->integer('beneficiarios_diretos')->default(0);
            $table->enum('status', ['Planejado', 'Em Andamento', 'Concluído', 'Cancelado'])->default('Planejado');
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('status');
            $table->index('localidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('esg_projetos_sociais');
    }
};

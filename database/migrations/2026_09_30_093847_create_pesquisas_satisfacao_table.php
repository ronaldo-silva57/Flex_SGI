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
        Schema::create('pesquisas_satisfacao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('cliente_id')
                ->nullable()
                ->constrained('clientes')
                ->nullOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('codigo', 40);
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->enum('tipo', ['NPS', 'CSAT', 'Personalizada'])->default('CSAT');
            $table->enum('canal', ['Email', 'Telefone', 'Presencial', 'Online'])->nullable();
            $table->date('data_inicio');
            $table->date('data_fim')->nullable();
            $table->enum('status', ['Planejada', 'Em andamento', 'Concluída', 'Cancelada'])->default('Planejada');
            $table->decimal('nota_media', 5, 2)->nullable();
            $table->integer('total_respostas')->default(0);
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id', 'status');
            $table->index('data_inicio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesquisas_satisfacao');
    }
};

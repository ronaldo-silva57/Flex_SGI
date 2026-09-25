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
        Schema::create('treinamentos_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treinamento_id')
                ->constrained('treinamentos')
                ->cascadeOnDelete();
            $table->foreignId('usuario_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->date('data_conclusao')->nullable();
            $table->date('validade_ate')->nullable();
            $table->decimal('nota', 5, 2)->nullable();
            $table->string('certificado_path', 500)->nullable();
            $table->enum('status', ['Pendente', 'Em andamento', 'Concluído', 'Vencido'])->default('Pendente');
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('treinamento_id');
            $table->index('usuario_id');
            $table->index('status');
            $table->index('data_conclusao');
            $table->index(['validade_ate', 'status']);

            $table->unique(['treinamento_id', 'usuario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treinamentos_usuarios');
    }
};

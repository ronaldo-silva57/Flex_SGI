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
        Schema::create('calendario_eventos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->string('titulo');
            $table->text('descricao')->nullable();
            $table->dateTimeTz('data_inicio');
            $table->dateTimeTz('data_fim')->nullable();
            $table->boolean('dia_inteiro')->default(false);
            $table->enum('categoria', ['Auditoria', 'Prazo SGI', 'Reunião', 'Treinamento', 'Manutenção', 'Outros'])->default('Prazo SGI');
            $table->string('cor', 20)->nullable(); //Para exibição no FullCalendar (Hex)
            $table->enum('status', ['Agendado', 'Realizado', 'Cancelado', 'Adiado'])->default('Agendado');
            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id', 'data_inicio']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendario_eventos');
    }
};

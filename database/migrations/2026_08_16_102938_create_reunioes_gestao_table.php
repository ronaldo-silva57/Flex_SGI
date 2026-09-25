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
        Schema::create('reunioes_gestao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')
                ->constrained('empresas')
                ->cascadeOnDelete();
            $table->foreignId('responsavel_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->date('data_reuniao');
            $table->enum('tipo', ['Revisão Direção', 'Gestão Integrada', 'Outros']);
            $table->text('pauta')->nullable();
            $table->text('decisoes')->nullable();
            $table->text('acoes_definidas')->nullable();
            $table->date('proxima_reuniao')->nullable();
            $table->text('ata')->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('empresa_id');
            $table->index('responsavel_id');
            $table->index('data_reuniao');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reunioes_gestao');
    }
};

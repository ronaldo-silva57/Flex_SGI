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
        Schema::create('ishikawa_causas', function (Blueprint $table) {
            $table->id();

            $table->foreignId('analise_ishikawa_id')
                ->constrained('analises_ishikawa')
                ->nullOnDelete();

            $table->foreignId('responsavel_validacao_id')
                ->constrained('users')
                ->nullOnDelete();

            //Ecemplos: Metodo, mão de obra, maquina, material,
            //medicao, meio ambiente, gestao, informacao
            $table->string('categoria', 40);
            $table->text('descricao');
            $table->text('evidencia')->nullable();

            $table->boolean('confirmada')->default(false);
            $table->boolean('causa_raiz')->default(false);

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['analise_ishikawa_id', 'categoria']);
            $table->index(['analise_ishikawa_id', 'causa_raiz']);
            $table->index('responsavel_validacao_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ishikawa_causas');
    }
};

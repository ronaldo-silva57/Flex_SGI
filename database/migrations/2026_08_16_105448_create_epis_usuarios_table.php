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
        Schema::create('epis_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('epi_id')
                ->constrained('epis')
                ->cascadeOnDelete();
            $table->foreignId('usuario_id')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->date('data_entrega')->nullable();
            $table->date('data_vencimento')->nullable();
            $table->integer('quantidade')->default(1);
            $table->foreignId('responsavel_entrega_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->enum('status', ['Ativo', 'Vencido', 'Devolvido'])->default('Ativo');
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('status');
            $table->index('data_vencimento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('epis_usuarios');
    }
};

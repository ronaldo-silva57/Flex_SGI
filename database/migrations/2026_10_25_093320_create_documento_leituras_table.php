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
        Schema::create('documento_leituras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('documento_id')
                ->constrained('documentos')
                ->cascadeOnDelete();
            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestampTz('data_leitura')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestampsTz();
            $table->softDeletes();

            $table->index('documento_id');
            $table->index('usuario_id');

            $table->unique(['documento_id', 'usuario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documento_leituras');
    }
};

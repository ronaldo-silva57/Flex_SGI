<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('produtos_quimicos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->cascadeOnDelete();
            $table->foreignId('fornecedor_id')->nullable()->constrained('fornecedores')->nullOnDelete();
            $table->foreignId('responsavel_id')->nullable()->constrained('users')->nullOnDelete();

            $table->string('nome');
            $table->string('fabricante', 255)->nullable();
            $table->string('numero_fispq', 100)->nullable();
            $table->string('numero_cas', 50)->nullable();
            $table->enum('estado_fisico', ['Sólido','Líquido','Gasoso','Pastoso','Outros'])->nullable();

            // Blocos da FISPQ/FDS
            $table->text('composicao')->nullable();
            $table->text('perigos_ghs')->nullable();
            $table->string('palavra_advertencia', 100)->nullable();
            $table->text('pictogramas')->nullable();
            $table->text('primeiros_socorros')->nullable();
            $table->text('combate_incendio')->nullable();
            $table->text('medidas_derramamento')->nullable();
            $table->text('manuseio_armazenamento')->nullable();
            $table->text('epi_necessario')->nullable();
            $table->text('epc_necessario')->nullable();

            $table->string('localizacao', 255)->nullable();
            $table->decimal('quantidade_estoque', 12, 3)->nullable();
            $table->string('unidade_medida', 20)->nullable();
            $table->date('data_validade')->nullable();
            $table->string('arquivo_fispq_path', 500)->nullable();
            $table->enum('status', ['Ativo','Inativo','Descontinuado'])->default('Ativo');

            $table->timestampsTz();
            $table->softDeletes();

            $table->index(['empresa_id','status']);
            $table->index('nome');
            $table->index('numero_cas');
            $table->index('fornecedor_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos_quimicos');
    }
};
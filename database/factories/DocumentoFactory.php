<?php

namespace Database\Factories;

use App\Models\Documento;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Processo;
use App\Models\Norma;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Documento>
 */
class DocumentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::first()->id,
            'processo_id' => Processo::inRandomOrder()->first()?->id,
            'norma_id' => Norma::inRandomOrder()->first()?->id,
            'responsavel_id' => User::first()->id,
            'codigo' => strtoupper($this->faker->bothify('DOC-###')),
            'titulo' => $this->faker->sentence(4),
            'tipo' => $this->faker->randomElement(['Política', 'Procedimento', 'Instrução', 'Registro', 'Formulário', 'Manual', 'Outro']),
            'versao' => $this->faker->randomElement(['1.0', '1.1', '2.0']),
            'conteudo' => $this->faker->paragraph(5),
            'arquivo_path' => $this->faker->optional()->filePath(),
            'status' => $this->faker->randomElement(['Rascunho', 'Em revisão', 'Aprovado', 'Obsoleto']),
            'data_aprovacao' => $this->faker->optional()->date(),
            'data_revisao' => $this->faker->optional()->date(),
        ];
    }
}

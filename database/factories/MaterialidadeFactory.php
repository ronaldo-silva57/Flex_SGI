<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\Materialidade;
use App\Models\Empresa;
use App\Models\EsgIndicador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class MaterialidadeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Materialidade::class;
    
    public function definition(): array
    {
        $importanciaStakeholders = $this->faker->numberBetween(1, 5);
        $importanciaNegocio = $this->faker->numberBetween(1, 5);

        // calcula classificação só para lógica de negócio
        $score = $importanciaStakeholders + $importanciaNegocio;
        $classificacao = match (true) {
            $score <= 3 => 'Baixa',
            $score <= 5 => 'Média',
            $score <= 7 => 'Alta',
            default => 'Crítica',
        };

        return [
            'empresa_id' => Empresa::first()->id,
            'esg_indicador_id' => EsgIndicador::factory(),
            'tema' => $this->faker->words(3, true),
            'importancia_stakeholders' => $importanciaStakeholders,
            'importancia_negocio' => $importanciaNegocio,
            'classificacao' => $classificacao,
        ];
    }
}

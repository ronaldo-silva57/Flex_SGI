<?php

namespace Database\Factories;

use App\Models\Competencia;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Competencia>
 */
class CompetenciaFactory extends Factory
{
    protected $model = Competencia::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'    => Empresa::factory(),
            'codigo'        => $this->faker->unique()->bothify('COMP-###'),
            'nome'          => $this->faker->word(),
            'descricao'     => $this->faker->sentence(12),
            'tipo'          => $this->faker->randomElement(['Técnica', 'Comportamental', 'Certificação', 'Treinamento']),
            'ativo'         => $this->faker->boolean(95),
        ];
    }
}

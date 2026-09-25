<?php

namespace Database\Factories;

use App\Models\Epi;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Epi>
 */
class EpiFactory extends Factory
{
    protected $model = Epi::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()->id,
            'nome'              => $this->faker->word() . ' ' . $this->faker->randomElement(['Capacete', 'Óculos', 'Luvas', 'Máscara', 'Protetor']),
            'descricao'         => $this->faker->optional()->sentence(6),
            'categoria'         => $this->faker->randomElement(['Cabeça', 'Olhos', 'Mãos', 'Respiratória', 'Audição']),
            'ca'                => $this->faker->optional()->numerify('CA-####'),
            'validade_meses'    => $this->faker->optional()->numberBetween(6, 60),
            'estoque_minimo'    => $this->faker->numberBetween(5, 20),
            'estoque_atual'     => $this->faker->numberBetween(0, 100),
            'ativo'             => $this->faker->boolean(80),
        ];
    }
}

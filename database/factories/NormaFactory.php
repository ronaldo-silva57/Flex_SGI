<?php

namespace Database\Factories;

use App\Models\Norma;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Norma>
 */
class NormaFactory extends Factory
{
    protected $model = \App\Models\Norma::class;

    public function definition(): array
    {
        return [
            'codigo' => $this->faker->unique()->bothify('N###'),
            'nome' => $this->faker->sentence(3),
            'versao' => $this->faker->randomElement(['1.0','2.0','3.0']),
            'descricao' => $this->faker->paragraph(),
            'ativo' => $this->faker->boolean(80), // 80% chance de ativo
        ];
    }
}
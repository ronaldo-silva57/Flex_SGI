<?php

namespace Database\Factories;

use App\Models\CargoCompetencia;
use App\Models\Cargo;
use App\Models\Competencia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class CargoCompetenciaFactory extends Factory
{
    protected $model = CargoCompetencia::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cargo_id' => Cargo::factory(),
            'competencia_id' => Competencia::factory(),
            'nivel_exigido' => $this->faker->randomElement(['Básico', 'Intermediário', 'Avançado']),
        ];
    }
}

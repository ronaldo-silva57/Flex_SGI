<?php

namespace Database\Factories;

use App\Models\UsuarioCompetencia;
use App\Models\User;
use App\Models\Competencia;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends Factory<Model>
 */
class UsuarioCompetenciaFactory extends Factory
{
    protected $model = UsuarioCompetencia::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'           => User::factory(),
            'competencia_id'    => Competencia::factory(),
            'nivel_atual'       => $this->faker->randomElement(['Básico', 'Intermediário', 'Avançado']),
            'data_obtencao'     => $this->faker->date(),
            'validade'          => $this->faker->optional()->date(),
            'observacoes'       => $this->faker->sentence(8),
        ];
    }
}

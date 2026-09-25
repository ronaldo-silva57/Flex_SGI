<?php

namespace Database\Factories;

use App\Models\Treinamento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TreinamentoUsuario>
 */
class TreinamentoUsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'treinamento_id' => Treinamento::factory(),
            'usuario_id' => User::factory(),
            'data_conclusao' => now()->subDays(10),
            'validade_ate' => now()->addMonths(12),
            'nota' => $this->faker->randomFloat(2, 6, 10),
            'certificado_path' => null,
            'status' => $this->faker->randomElement(['Pendente', 'Em andamento', 'Concluído', 'Vencido']),
        ];
    }
}

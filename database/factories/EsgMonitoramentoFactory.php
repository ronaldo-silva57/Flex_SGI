<?php

namespace Database\Factories;

use App\Models\EsgMonitoramento;
use App\Models\EsgIndicador;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class EsgMonitoramentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'esg_indicador_id' => EsgIndicador::factory(),
            'responsavel_id' => User::first()->id,
            'periodo_referencia' => $this->faker->date(),
            'valor_realizado' => $this->faker->randomFloat(2, 0, 1000),
            'valor_meta' => $this->faker->randomFloat(2, 0, 1000),
            'analise' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement(['No prazo', 'Atrasado', 'Concluído']),
        ];
    }
}

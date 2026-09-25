<?php

namespace Database\Factories;

use App\Models\Monitoramento;
use App\Models\Indicador;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Monitoramento>
 */
class MonitoramentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'indicador_id' => Indicador::inRandomOrder()->first()->id ?? Indicador::factory(),
            'responsavel_id' => User::first()->id,
            'periodo_referencia' => $this->faker->date('d/m/Y'),
            'valor_realizado' => $this->faker->randomFloat(2, 100, 1000),
            'valor_meta' => $this->faker->randomFloat(2, 100, 1000),
            'analise' => $this->faker->sentence(),
            'acao_necessaria' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['No prazo', 'Atrasado', 'Concluído']),
        ];
    }
}

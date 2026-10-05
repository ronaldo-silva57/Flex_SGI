<?php

namespace Database\Factories;

use App\Models\IndicadorAmbiental;
use App\Models\MonitoramentoAmbiental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MonitoramentoAmbiental>
 */
class MonitoramentoAmbientalFactory extends Factory
{
    protected $model = MonitoramentoAmbiental::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
$meta = fake()->randomFloat(2, 50, 200);
        $realizado = fake()->randomFloat(2, 40, 210);

        return [
            'indicador_ambiental_id' => IndicadorAmbiental::first()?->id ?? 1,
            'responsavel_id' => User::first()?->id ?? 1,
            'periodo_referencia' => date('Y-m'),
            'valor_realizado' => $realizado,
            'valor_meta' => $meta,
            'analise' => 'O resultado obtido ficou dentro da margem de variação esperada para o período operacional.',
            'acao_necessaria' => $realizado > $meta ? 'Acompanhar a medição do próximo mês e reforçar auditoria de desperdícios.' : null,
            'status' => fake()->randomElement(['No prazo', 'Atrasado', 'Concluído']),
        ];
    }
}

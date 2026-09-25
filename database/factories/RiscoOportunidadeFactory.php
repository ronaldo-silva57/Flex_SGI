<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Processo;
use App\Models\RiscoOportunidade;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RiscoOportunidade>
 */
class RiscoOportunidadeFactory extends Factory
{
    protected $model = RiscoOportunidade::class;

    public function definition(): array
    {
        $empresa = Empresa::first();
        $usuario = User::first();
        $processo = Processo::inRandomOrder()->first();

        return [
            'empresa_id'      => $empresa->id,
            'processo_id'     => $processo?->id,
            'responsavel_id'  => $usuario->id,

            'tipo' => $this->faker->randomElement([
                'Risco',
                'Oportunidade',
            ]),

            'descricao' => $this->faker->sentence(12),

            'causa' => $this->faker->sentence(8),

            'consequencia' => $this->faker->sentence(10),

            'probabilidade' => $this->faker->numberBetween(1, 5),

            'impacto' => $this->faker->numberBetween(1, 5),

            'tratamento' => $this->faker->randomElement([
                'Eliminar',
                'Mitigar',
                'Transferir',
                'Aceitar',
            ]),

            'plano_acao' => $this->faker->paragraph(),

            'prazo' => $this->faker
                ->dateTimeBetween('now', '+1 year')
                ->format('Y-m-d'),

            'status' => $this->faker->randomElement([
                'Aberto',
                'Em andamento',
                'Concluído',
                'Cancelado',
            ]),

            'evidencia' => $this->faker->sentence(15),
        ];
    }
}
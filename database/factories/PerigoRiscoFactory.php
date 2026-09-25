<?php

namespace Database\Factories;

use App\Models\PerigoRisco;
use App\Models\Empresa;
use App\Models\Processo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PerigoRisco>
 */
class PerigoRiscoFactory extends Factory
{
    protected $model = PerigoRisco::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $empresa = Empresa::firstOrCreate([
            'id' => 1,
        ]);

        return [
            'empresa_id'       => $empresa->id,

            'processo_id'      => Processo::where('empresa_id', $empresa->id)
                ->inRandomOrder()
                ->value('id'),

            'responsavel_id'   => User::first()?->id,

            'descricao_perigo' => $this->faker->sentence(5),

            'risco_associado'   => $this->faker->optional()->sentence(4),

            'exposicao'         => $this->faker->optional()->sentence(3),

            'probabilidade'     => $this->faker->numberBetween(1, 5),

            'severidade'        => $this->faker->numberBetween(1, 5),

            'medida_controle'  => $this->faker->optional()->sentence(5),

            'necessita_acao'   => $this->faker->boolean(30),

            'status'           => $this->faker->randomElement([
                'Ativo',
                'Eliminado',
                'Em tratamento',
            ]),
        ];
    }
}
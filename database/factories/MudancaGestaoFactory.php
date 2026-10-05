<?php

namespace Database\Factories;

use App\Models\MudancaGestao;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Processo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MudancaGestao>
 */
class MudancaGestaoFactory extends Factory
{
    protected $model = MudancaGestao::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::first()->id,
            'solicitante_id' => User::first()->id,
            'responsavel_aprovacao_id' => User::first()->id,
            'processo_id' => Processo::factory(),

            'codigo' => $this->faker->unique()->numerify('MG-###'),
            'titulo' => $this->faker->sentence(4),
            'tipo' => $this->faker->randomElement([
                'Processo', 'Equipamento', 'Layout', 'Documento',
                'Pessoas/Estrutura', 'Sistema/IT', 'Outros'
            ]),
            'descricao_mudanca' => $this->faker->paragraph(),
            'justificativa' => $this->faker->paragraph(),

            'impacto_qualidade' => $this->faker->sentence(),
            'impacto_ambiental' => $this->faker->sentence(),
            'impacto_sso' => $this->faker->sentence(),
            'impacto_seguranca_informacao' => $this->faker->sentence(),

            'data_prevista' => $this->faker->date(),
            'data_implementacao' => null,
            'status' => 'Proposta',
            'parecer_aprovacao' => null,
        ];
    }
}

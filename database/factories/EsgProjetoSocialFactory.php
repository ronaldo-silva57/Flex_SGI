<?php

namespace Database\Factories;

use App\Models\EsgProjetoSocial;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EsgProjetoSocial>
 */
class EsgProjetoSocialFactory extends Factory
{
    protected $model = EsgProjetoSocial::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'            => Empresa::first()?->id,
            'responsavel_id'        => User::first()?->id,
            'nome_projeto'          => $this->faker->sentence(3),
            'descricao'             => $this->faker->paragraph(),
            'localidade'            => $this->faker->city(),
            'data_inicio'           => $this->faker->optional()->date(),
            'data_fim'              => $this->faker->optional()->date(),
            'orcamento_investido'   => $this->faker->randomFloat(2, 10000, 500000),
            'beneficiarios_diretos' => $this->faker->numberBetween(50, 5000),
            'status'                => $this->faker->randomElement(['Planejado', 'Em Andamento', 'Concluído', 'Cancelado']),
        ];
    }
}

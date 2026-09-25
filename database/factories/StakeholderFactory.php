<?php

namespace Database\Factories;

use App\Models\Stakeholder;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Stakeholder>
 */
class StakeholderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::first()->id,
            'nome' => $this->faker->name(),
            'tipo' => $this->faker->randomElement([
                'Cliente', 'Colaborador', 'Fornecedor', 'Comunidade', 'Investidor', 'Governo', 'Outros'
            ]),
            'contato' => $this->faker->safeEmail(),
            'expectativas' => $this->faker->sentence(8),
            'necessidades' => $this->faker->sentence(10),
            'prioridade' => $this->faker->numberBetween(1, 5),
            'ativo' => $this->faker->boolean(80), // 80% ativos
        ];
    }
}

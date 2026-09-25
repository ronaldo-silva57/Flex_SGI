<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\AcaoCorretiva;
use App\Models\NaoConformidade;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class AcaoCorretivaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nao_conformidade_id'   => NaoConformidade::inRandomOrder()->first()->id,
            'responsavel_id'        => User::first()->id,
            'etapa'                 => $this->faker->randomElement(['Contenção', 'Causa raiz', 'Correção', 'Verificação', 'Conclusão']),
            'descricao'             => $this->faker->sentence(12),
            'prazo'                 => $this->faker->optional()->date(),
            'data_execucao'         => $this->faker->optional()->date(),
            'eficaz'                => $this->faker->optional()->boolean(),
            'evidencia'             => $this->faker->optional()->paragraph(),
            'status'                => $this->faker->randomElement(['Pendente', 'Em andamento', 'Concluída', 'Reprovada']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\ProjetoTarefa;
use App\Models\Projeto;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProjetoTarefa>
 */
class ProjetoTarefaFactory extends Factory
{
    protected $model = ProjetoTarefa::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'projeto_id' => Projeto::factory(),
            'responsavel_id' => User::first()->id,
            'titulo' => $this->faker->sentence(4),
            'descricao' => $this->faker->paragraph(),
            'status_kanban' => $this->faker->randomElement(['A Fazer', 'Em Progresso', 'Em Revisão', 'Concluído']),
            'prioridade' => $this->faker->randomElement(['Baixa', 'Média', 'Alta', 'Urgente']),
            'data_inicio' => $this->faker->optional()->date(),
            'data_vencimento' => $this->faker->optional()->dateTimeBetween('+1 week', '+6 months'),
            'ordem' => $this->faker->numberBetween(0, 10),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Projeto;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Projeto>
 */
class ProjetoFactory extends Factory
{
    protected $model = Projeto::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::first()->id, 
            'responsavel_id' => User::first()->id, 
            'codigo' => $this->faker->unique()->bothify('PRJ-###'),
            'nome' => $this->faker->sentence(3),
            'descricao' => $this->faker->paragraph(),
            'data_inicio' => $this->faker->optional()->date(),
            'data_fim_prevista' => $this->faker->optional()->dateTimeBetween('+1 month', '+1 year'),
            'data_fim_real' => $this->faker->optional()->dateTimeBetween('+2 months', '+2 years'),
            'status' => $this->faker->randomElement(['Planejamento', 'Em andamento', 'Suspenso', 'Concluído', 'Cancelado']),
            'progresso_percentual' => $this->faker->numberBetween(0, 100),
        ];
    }
}

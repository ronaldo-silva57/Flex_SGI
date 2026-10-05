<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\PlanoAcao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlanoAcao>
 */
class PlanoAcaoFactory extends Factory
{
    protected $model = PlanoAcao::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
$prazoInicio = fake()->dateTimeBetween('-2 months', 'now');
        $prazoFim = (clone $prazoInicio)->modify('+30 days');

        return [
            'empresa_id' => Empresa::first()?->id ?? 1,
            'responsavel_id' => User::first()?->id ?? 1,
            'origem_type' => null,
            'origem_id' => null,
            'codigo' => 'PA-' . fake()->unique()->numberBetween(1000, 9999),
            'titulo' => fake()->sentence(4),
            'o_que' => fake()->paragraph(),
            'por_que' => 'Garantir a conformidade com as diretrizes do SGI e evitar reincidências.',
            'onde' => fake()->randomElement(['Setor de Produção', 'Almoxarifado', 'Laboratório CQ', 'Administrativo']),
            'como' => fake()->paragraph(),
            'quanto_custa' => fake()->randomFloat(2, 100, 15000),
            'prazo_inicio' => $prazoInicio->format('Y-m-d'),
            'prazo_fim' => $prazoFim->format('Y-m-d'),
            'data_conclusao' => null,
            'progresso' => fake()->numberBetween(0, 100),
            'status' => fake()->randomElement(['Pendente', 'Em andamento', 'Em verificação', 'Concluído', 'Cancelado']),
            'eficaz' => fake()->optional()->boolean(),
            'evidencia_conclusao' => fake()->optional()->sentence(),
            'observacoes' => fake()->optional()->sentence(),
        ];
    }
}

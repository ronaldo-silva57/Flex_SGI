<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Empresa;
use App\Models\PesquisaSatisfacao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PesquisaSatisfacao>
 */
class PesquisaSatisfacaoFactory extends Factory
{
    protected $model = PesquisaSatisfacao::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
 return [
            'empresa_id' => Empresa::first()?->id ?? 1,
            'cliente_id' => Cliente::first()?->id,
            'responsavel_id' => User::first()?->id ?? 1,
            'codigo' => 'PS-' . fake()->unique()->numberBetween(100, 999),
            'titulo' => 'Pesquisa de Satisfação de Clientes ' . date('Y'),
            'descricao' => 'Avaliação do nível de satisfação do cliente quanto ao atendimento, prazos e qualidade.',
            'tipo' => fake()->randomElement(['NPS', 'CSAT', 'Personalizada']),
            'canal' => fake()->randomElement(['Email', 'Telefone', 'Presencial', 'Online']),
            'data_inicio' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'data_fim' => fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d'),
            'status' => fake()->randomElement(['Planejada', 'Em andamento', 'Concluída', 'Cancelada']),
            'nota_media' => fake()->randomFloat(2, 7, 10),
            'total_respostas' => fake()->numberBetween(10, 100),
        ];
    }
}

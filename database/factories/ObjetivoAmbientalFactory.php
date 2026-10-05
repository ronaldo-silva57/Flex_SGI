<?php

namespace Database\Factories;

use App\Models\AspectoAmbiental;
use App\Models\Empresa;
use App\Models\ObjetivoAmbiental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ObjetivoAmbiental>
 */
class ObjetivoAmbientalFactory extends Factory
{
    protected $model = ObjetivoAmbiental::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $inicio = fake()->dateTimeBetween('-3 months', 'now');
        $prazo = (clone $inicio)->modify('+6 months');

        return [
            'empresa_id' => Empresa::first()?->id ?? 1,
            'responsavel_id' => User::first()?->id ?? 1,
            'aspecto_ambiental_id' => AspectoAmbiental::first()?->id,
            'codigo' => 'OBJ-AMB-' . fake()->unique()->numberBetween(10, 99),
            'titulo' => fake()->randomElement([
                'Redução do Consumo de Energia Elétrica',
                'Redução da Geração de Resíduos Classe I',
                'Otimização do Consumo de Água Potável',
                'Implementação de Coleta Seletiva 100% Eficaz'
            ]),
            'descricao' => fake()->sentence(10),
            'indicador' => 'kWh / Tonelada Produzida',
            'meta' => fake()->randomFloat(2, 5, 20),
            'unidade_medida' => '%',
            'recursos_necessarios' => 'Treinamento de equipes, adequação de lâmpadas para LED e instalação de sensores.',
            'responsaveis_execucao' => 'Equipe da Gestão Ambiental e Manutenção',
            'data_inicio' => $inicio->format('Y-m-d'),
            'prazo' => $prazo->format('Y-m-d'),
            'data_conclusao' => null,
            'progresso' => fake()->numberBetween(0, 100),
            'evidencia' => fake()->optional()->sentence(),
            'status' => fake()->randomElement(['Planejado', 'Em andamento', 'Concluído', 'Cancelado', 'Atrasado']),
        ];
    }
}

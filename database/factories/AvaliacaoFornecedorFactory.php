<?php

namespace Database\Factories;

use App\Models\AvaliacaoFornecedor;
use App\Models\Empresa;
use App\Models\Fornecedor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AvaliacaoFornecedor>
 */
class AvaliacaoFornecedorFactory extends Factory
{
    protected $model = AvaliacaoFornecedor::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
$notaQualidade = fake()->randomFloat(2, 60, 100);
        $notaPrazo = fake()->randomFloat(2, 50, 100);
        $notaAtendimento = fake()->randomFloat(2, 70, 100);
        $notaEsg = fake()->randomFloat(2, 60, 100);
        $notaFinal = round(($notaQualidade + $notaPrazo + $notaAtendimento + $notaEsg) / 4, 2);

        return [
            'empresa_id' => Empresa::first()?->id ?? 1,
            'fornecedor_id' => Fornecedor::first()?->id ?? 1,
            'avaliador_id' => User::first()?->id ?? 1,
            'periodo_referencia' => date('Y') . '-Q' . fake()->numberBetween(1, 4),
            'nota_qualidade' => $notaQualidade,
            'nota_prazo' => $notaPrazo,
            'nota_atendimento' => $notaAtendimento,
            'nota_esg_ambiental' => $notaEsg,
            'nota_final' => $notaFinal,
            'status_qualificacao' => fake()->randomElement(['Aprovado', 'Aprovado com Restrição', 'Reprovado', 'Em observação']),
            'observacoes' => fake()->optional()->sentence(),
            'plano_acao_exigido' => fake()->optional()->sentence(),
        ];
    }
}

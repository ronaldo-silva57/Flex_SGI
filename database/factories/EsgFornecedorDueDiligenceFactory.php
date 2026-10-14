<?php

namespace Database\Factories;

use App\Models\EsgFornecedorDueDiligence;
use App\Models\Empresa;
use App\Models\Stakeholder;
use Illuminate\Database\Eloquent\Factories\Factory;
/**
 * @extends Factory<Model>
 */
class EsgFornecedorDueDiligenceFactory extends Factory
{
    protected $model = EsgFornecedorDueDiligence::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()?->id,
            'stakeholder_id'    => Stakeholder::factory(),
            'nome_fornecedor'   => $this->faker->company(),
            'cnpj_fornecedor'   => $this->faker->cnpj(false),
            'nivel_risco'       => $this->faker->randomElement(['Baixo', 'Médio', 'Alto', 'Crítico']),
            'data_avaliacao'    => $this->faker->date(),
            'possui_politica_anticorrupcao' => $this->faker->boolean(70),
            'possui_trabalho_infantil_analise' => $this->faker->boolean(10),
            'parecer_esg'       => $this->faker->optional()->sentence(12),
            'status_aprovacao'  => $this->faker->randomElement(['Aprovado', 'Aprovado com Ressalvas', 'Reprovado', 'Em Análise']),
        ];
    }
}

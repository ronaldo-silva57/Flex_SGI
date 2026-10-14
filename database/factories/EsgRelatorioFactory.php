<?php

namespace Database\Factories;

use App\Models\EsgRelatorio;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EsgRelatorio>
 */
class EsgRelatorioFactory extends Factory
{
    protected $model = EsgRelatorio::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()?->id,
            'responsavel_id'    => User::first()?->id,
            'titulo'            => 'Relatório Anual de Sustentabilidade ' . $this->faker->year(),
            'framework'         => $this->faker->randomElement(['GRI', 'SASB', 'TCFD', 'Global Compact', 'Outro']),
            'ano_referencia'    => $this->faker->year(),
            'status'            => $this->faker->randomElement(['Rascunho', 'Em Revisão', 'Auditado', 'Publicado']),
            'data_publicacao'   => $this->faker->optional()->date(),
            'arquivo_path'      => null,
            'observacoes'       => $this->faker->optional()->sentence(10),
        ];
    }
}

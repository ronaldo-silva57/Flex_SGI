<?php

namespace Database\Factories;

use App\Models\NaoConformidade;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Norma;
use App\Models\Clausula;
use App\Models\Processo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NaoConformidade>
 */
class NaoConformidadeFactory extends Factory
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
            'responsavel_id' => User::first()->id,
            'norma_id' => Norma::inRandomOrder()->first()->id ?? null,
            'clausula_id' => Clausula::inRandomOrder()->first()->id ?? null,
            'processo_id' => Processo::inRandomOrder()->first()->id ?? null,
            'origem' => $this->faker->randomElement(['Auditoria', 'Monitoramento', 'Reclamacao', 'Incidente', 'Outros']),
            'descricao' => $this->faker->sentence(12),
            'evidencia' => $this->faker->optional()->paragraph(),
            'gravidade' => $this->faker->randomElement(['Baixa', 'Media', 'Alta', 'Crítica']),
            'status' => $this->faker->randomElement(['Aberta', 'Em analise', 'Em ação', 'Verificação', 'Fechada']),
            'data_abertura' => $this->faker->date(),
            'data_fechamento' => $this->faker->optional()->date(),
        ];
    }
}

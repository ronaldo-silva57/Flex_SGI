<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Empresa;

/**
 * @extends Factory<Model>
 */
class DepartamentoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()->id,
            'nome'              => $this->faker->word,
            'descricao'         => $this->faker->sentence,
            'responsavel_id'    => null, // pode ser ajustado posteriormente
            'ativo'             => true,
        ];
    }
}

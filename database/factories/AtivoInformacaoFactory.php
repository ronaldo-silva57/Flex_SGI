<?php

namespace Database\Factories;

use App\Models\AtivoInformacao;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AtivoInformacao>
 */
class AtivoInformacaoFactory extends Factory
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
            'nome' => $this->faker->word(),
            'descricao' => $this->faker->sentence(),
            'tipo' => $this->faker->randomElement(['Hardware', 'Software', 'Dados', 'Servico', 'Pessoas', 'Instalações', 'Intangível']),
            'localizacao' => $this->faker->address(),
            'proprietario_id' => User::factory(),
            'classificacao' => $this->faker->randomElement(['Público', 'Interno', 'Confidencial', 'Restrito']),
            'valor' => $this->faker->randomFloat(2, 100, 10000),
            'status' => $this->faker->randomElement(['Ativo', 'Inativo', 'Descartado']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\EsgIndicador;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EsgIndicador>
 */
class EsgIndicadorFactory extends Factory
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
            'dimensao' => $this->faker->randomElement(['Ambiental', 'Social', 'Governança']),
            'codigo' => strtoupper($this->faker->lexify('IND-???')),
            'nome' => $this->faker->sentence(3),
            'descricao' => $this->faker->paragraph(),
            'formula' => $this->faker->sentence(),
            'meta' => $this->faker->randomFloat(2, 10, 1000),
            'unidade_medida' => $this->faker->randomElement(['kg', 'm³', 'ton', '%']),
            'frequencia' => $this->faker->randomElement(['Mensal', 'Trimestral', 'Semestral', 'Anual']),
            'referencia_gri' => $this->faker->lexify('GRI-???'),
            'ativo' => $this->faker->boolean(90), // 90% chance de estar ativo
        ];
    }
}

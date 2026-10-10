<?php

namespace Database\Factories;

use App\Models\InventarioGee;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InventarioGee>
 */
class InventarioGeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::factory(),
            'responsavel_id' => User::factory(),

            'codigo' => $this->faker->unique()->numerify('INV-####'),
            'ano_referencia' => $this->faker->year(),
            'escopo' => $this->faker->randomElement(['1','2','3']),
            'categoria' => $this->faker->randomElement(['Combustão móvel','Energia elétrica','Resíduos']),
            'fonte_emissao' => $this->faker->sentence(3),
            'quantidade' => $this->faker->randomFloat(3, 10, 1000),
            'unidade' => $this->faker->randomElement(['litros','kWh','toneladas']),
            'fator_emissao' => $this->faker->randomFloat(6, 0.001, 0.5),
            'emissao_tco2e' => $this->faker->randomFloat(6, 1, 500),
            'metodologia' => $this->faker->sentence(),
            'referencia_fator' => $this->faker->company(),
            'evidencia' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['Rascunho','Em revisão','Verificado','Publicado']),
        ];
    }
}

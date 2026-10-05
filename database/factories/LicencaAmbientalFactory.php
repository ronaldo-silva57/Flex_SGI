<?php

namespace Database\Factories;

use App\Models\LicencaAmbiental;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LicencaAmbiental>
 */
class LicencaAmbientalFactory extends Factory
{
    protected $model = LicencaAmbiental::class;

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

            'numero' => $this->faker->unique()->numerify('LIC-#####'),
            'tipo' => $this->faker->randomElement(['LP','LI','LO','LAC','LAS','LAU','Outros']),
            'orgao_emissor' => $this->faker->company(),
            'descricao' => $this->faker->sentence(),
            'condicionantes' => $this->faker->paragraph(),
            'data_emissao' => $this->faker->date(),
            'data_validade' => $this->faker->dateTimeBetween('+1 year', '+3 years')->format('Y-m-d'),
            'data_renovacao' => null,
            'arquivo_path' => null,
            'status' => 'Vigente',
            'observacoes' => $this->faker->sentence(),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\CipaReuniao;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CipaReuniao>
 */
class CipaReuniaoFactory extends Factory
{
    protected $model = CipaReuniao::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()->id,
            'presidente_id'     => User::factory(),
            'secretario_id'     => User::factory(),

            'gestao_ano'        => '2026/2027',
            'tipo'              => $this->faker->randomElement(['Ordinária','Extraordinária','Inspeção de Campo','DDSGeral']),
            'data_reuniao'      => $this->faker->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            'pauta_principal'   => $this->faker->sentence(3),
            'pauta_detalhada'   => $this->faker->paragraph(),
            'deliberacoes'      => $this->faker->paragraph(),
            'ata_arquivo_path'  => null,
            'status'            => $this->faker->randomElement(['Agendada','Realizada','Cancelada']),
        ];
    }
}

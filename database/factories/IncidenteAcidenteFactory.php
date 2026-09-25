<?php

namespace Database\Factories;

use App\Models\IncidenteAcidente;
use App\Models\Empresa;
use App\Models\User;    
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IncidenteAcidente>
 */
class IncidenteAcidenteFactory extends Factory
{
    protected $model = IncidenteAcidente::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()->id,
            'usuario_id'        => User::first()->id,
            'responsavel_id'    => User::first()->id,
            'data_ocorrencia'   => $this->faker->dateTimeBetween('-1 year', 'now'),
            'local'             => $this->faker->optional()->city(),
            'tipo'              => $this->faker->randomElement(['Quase acidente', 'Incidente', 'Acidente leve', 'Acidente grave', 'Fatal']),
            'descricao'         => $this->faker->paragraph(),
            'causas'            => $this->faker->optional()->text(100),
            'lesao'             => $this->faker->optional()->text(50),
            'dias_perdidos'     => $this->faker->numberBetween(0, 30),
            'tratamento'        => $this->faker->optional()->text(80),
            'investigacao'      => $this->faker->optional()->text(100),
            'acao_corretiva'    => $this->faker->optional()->text(80),
            'status'            => $this->faker->randomElement(['Aberto', 'Em investigação', 'Concluído']),
        ];
    }
}

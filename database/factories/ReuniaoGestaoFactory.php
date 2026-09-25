<?php

namespace Database\Factories;

use App\Models\ReuniaoGestao;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReuniaoGestao>
 */
class ReuniaoGestaoFactory extends Factory
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
            'data_reuniao' => $this->faker->date(),
            'tipo' => $this->faker->randomElement(['Revisão Direção', 'Gestão Integrada', 'Outros']),
            'pauta' => $this->faker->sentence(8),
            'decisoes' => $this->faker->paragraph(),
            'acoes_definidas' => $this->faker->paragraph(),
            'proxima_reuniao' => $this->faker->optional()->date(),
            'ata' => $this->faker->paragraph(3),
        ];
    }
}

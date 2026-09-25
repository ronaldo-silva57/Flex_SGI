<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TreinamentoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::factory(),
            'responsavel_id' => User::factory(),
            'titulo' => $this->faker->sentence(4),
            'descricao' => $this->faker->paragraph(),
            'conteudo' => $this->faker->text(),
            'carga_horaria' => $this->faker->numberBetween(4, 40),
            'tipo' => $this->faker->randomElement(['Obrigatório', 'Recomendado', 'Capacitação']),
            'validade_meses' => $this->faker->randomElement([12, 24, 36]),
            'status' => 'Ativo',
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Auditoria;
use App\Models\Empresa;
use App\Models\Norma;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditoriaFactory extends Factory
{
    protected $model = Auditoria::class;

    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()->id, 
            'norma_id'          => Norma::inRandomOrder()->first()->id ?? null,
            'auditor_lider_id'  => User::inRandomOrder()->first()->id ?? null,
            'tipo'              => $this->faker->randomElement(['Interna', 'Externa', 'Terceira parte']),
            'escopo'            => $this->faker->optional()->sentence(10),
        'objetivo'              => $this->faker->optional()->sentence(12),
            'data_inicio'       => $this->faker->date(),
            'data_fim'          => $this->faker->optional()->date(),
            'status'            => $this->faker->randomElement(['Planejada', 'Em andamento', 'Concluída', 'Cancelada']),
            'relatorio'         => $this->faker->optional()->paragraph(),
        ];
    }
}

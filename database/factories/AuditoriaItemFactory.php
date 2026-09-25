<?php

namespace Database\Factories;

use App\Models\AuditoriaItem;
use App\Models\Auditoria;
use App\Models\Clausula;
use App\Models\Processo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuditoriaItemFactory extends Factory
{
    protected $model = AuditoriaItem::class;

    public function definition(): array
    {
        return [
            'auditoria_id'          => Auditoria::inRandomOrder()->first()->id,
            'clausula_id'           => Clausula::inRandomOrder()->first()->id ?? null,
            'processo_id'           => Processo::inRandomOrder()->first()->id ?? null,
            'auditor_id'            => User::inRandomOrder()->first()->id ?? null,
            'descricao_verificacao' => $this->faker->sentence(12),
            'evidencia_coletada'    => $this->faker->optional()->paragraph(),
            'conformidade'          => $this->faker->optional()->randomElement([
                'conforme',
                'nao_conforme',
                'oportunidade_melhoria',
                'nao_aplicavel'
            ]),
            'observacoes'           => $this->faker->optional()->sentence(10),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\AspectoAmbiental;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Empresa;
use App\Models\Processo;
use App\Models\User;

class AspectoAmbientalFactory extends Factory
{
    protected $model = AspectoAmbiental::class;

    public function definition()
    {
        return [
            'empresa_id'         => Empresa::first()->id, 
            'processo_id'       => Processo::factory(),
            'responsavel_id'    => User::factory(),
            'descricao'         => $this->faker->sentence(6),
            'tipo'              => $this->faker->randomElement(['Emissao ar', 'Efluente', 'Resíduo', 'Ruído', 'Uso recurso', 'Outros']),
            'impacto_associado' => $this->faker->optional()->sentence(5),
            'significancia'     => $this->faker->optional()->numberBetween(1, 5),
            'controle_existente'=> $this->faker->optional()->sentence(4),
            'programa_gestao'   => $this->faker->optional()->sentence(4),
            'status'            => $this->faker->randomElement(['ativo', 'inativo']),
        ];
    }
}
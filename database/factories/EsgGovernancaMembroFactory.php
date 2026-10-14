<?php

namespace Database\Factories;

use App\Models\EsgGovernancaMembro;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EsgGovernancaMembro>
 */
class EsgGovernancaMembroFactory extends Factory
{
    protected $model = EsgGovernancaMembro::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()?->id,
            'nome'              => $this->faker->name(),
            'orgao'             => $this->faker->randomElement(['Conselho de Administração', 'Diretoria Executiva', 'Comitê de Auditoria', 'Comitê ESG', 'Outro']),
            'cargo'             => $this->faker->jobTitle(),
            'independente'      => $this->faker->boolean(40),
            'inicio_mandato'    => $this->faker->optional()->date(),
            'fim_mandato'       => $this->faker->optional()->date(),
            'ativo'             => $this->faker->boolean(90),
        ];
    }
}

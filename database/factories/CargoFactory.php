<?php

namespace Database\Factories;

use App\Models\Cargo;
use App\Models\Empresa;
use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cargo>
 */
class CargoFactory extends Factory
{
    protected $model = Cargo::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()->id,
            'departamento_id'   => Departamento::factory(),
            'codigo'            => $this->faker->unique()->bothify('CARGO-###'),
            'nome'              => $this->faker->jobTitle(),
            'descricao'         => $this->faker->sentence('10'),
            'requisitos'        => $this->faker->sentence(8),
            'ativo'             => $this->faker->boolean(90),
        ];
    }
}

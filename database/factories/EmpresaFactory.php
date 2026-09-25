<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codigo'        => strtoupper($this->faker->unique()->bothify('N###')),
            'razao_social'  => $this->faker->company,
            'nome_fantasia' => $this->faker->companySuffix,
            'cnpj'          => $this->faker->unique()->numerify('##.###.###/####-##'),
            'ie'            => $this->faker->numerify('#########'),
            'endereco'      => $this->faker->address,
            'cidade'        => $this->faker->city,
            'estado'        => $this->faker->stateAbbr,
            'cep'           => $this->faker->numerify('#####-###'),
            'telefone'      => $this->faker->phoneNumber,
            'email'         => $this->faker->unique()->safeEmail,
            'ativo'         => true,
        ];
    }
}

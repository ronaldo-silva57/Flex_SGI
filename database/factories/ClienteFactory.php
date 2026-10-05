<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cliente>
 */
class ClienteFactory extends Factory
{
    protected $model = Cliente::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::first()->id,

            'tipo_documento' => $this->faker->randomElement(['cpf','cnpj']),
            'documento' => $this->faker->unique()->numerify('###########'),
            'nome' => $this->faker->name(),
            'razao_social' => $this->faker->company(),
            'contato_principal' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'telefone' => $this->faker->phoneNumber(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->stateAbbr(),
            'endereco_completo' => $this->faker->address(),
            'status' => $this->faker->randomElement(['ativo','inativo','bloqueado_sgi']),
            'observacoes_compliance' => $this->faker->sentence(),
        ];
    }
}

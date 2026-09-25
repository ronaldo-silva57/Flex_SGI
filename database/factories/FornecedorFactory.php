<?php

namespace Database\Factories;

use App\Models\Fornecedor;
use App\Models\Empresa; 
use Illuminate\Database\Eloquent\Factories\Factory;

class FornecedorFactory extends Factory
{
    protected $model = Fornecedor::class;

    public function definition(): array
    {
        return [
            'codigo'             => $this->faker->unique()->numerify('FORN###'),
            'razao_social'       => $this->faker->company,
            'nome_fantasia'      => $this->faker->companySuffix,
            'cnpj'               => $this->faker->unique()->numerify('##.###.###/####-##'),
            'contato_nome'       => $this->faker->name,
            'contato_email'      => $this->faker->unique()->safeEmail,
            'contato_telefone'   => $this->faker->phoneNumber,
            'endereco'           => $this->faker->address,
            'categoria'          => $this->faker->word,
            'avaliacao_risco'    => $this->faker->numberBetween(1, 5),
            'ativo'              => $this->faker->boolean(80), // 80% de chance de ser ativo
        ];
    }
}
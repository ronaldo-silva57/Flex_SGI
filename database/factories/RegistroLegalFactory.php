<?php

namespace Database\Factories;

use App\Models\RegistroLegal;
use App\Models\Empresa;
use App\Models\Norma;
use Illuminate\Database\Eloquent\Factories\Factory;

class RegistroLegalFactory extends Factory
{
    protected $model = RegistroLegal::class;

    public function definition()
    {
        return [
            'empresa_id'      => Empresa::first()->id, 
            'norma_id'        => Norma::factory(),
            'numero'          => $this->faker->optional()->numerify('LEI-####'),
            'orgao'           => $this->faker->optional()->company(),
            'descricao'       => $this->faker->sentence(10),
            'tipo'            => $this->faker->randomElement(['Lei', 'Decreto', 'Normativa', 'Convênio', 'Resolução']),
            'data_publicacao' => $this->faker->optional()->date(),
            'data_vigencia'   => $this->faker->optional()->date(),
            'status'          => $this->faker->randomElement(['Vigente', 'Revogado', 'Em revisão']),
            'arquivo_path'    => $this->faker->optional()->filePath(),
        ];
    }
}
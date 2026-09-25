<?php

namespace Database\Factories;

use App\Models\Indicador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Indicador>
 */
class IndicadorFactory extends Factory
{
    protected $model = Indicador::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'     => 1,
            'processo_id'    => $this->faker->optional()->randomElement(\App\Models\Processo::pluck('id')->toArray()),
            'norma_id'       => $this->faker->optional()->randomElement(\App\Models\Norma::pluck('id')->toArray()),
            'responsavel_id' => $this->faker->optional()->randomElement(\App\Models\User::pluck('id')->toArray()),

            'codigo'         => strtoupper($this->faker->bothify('IND-###')),
            'nome'           => $this->faker->sentence(3),
            'descricao'      => $this->faker->optional()->paragraph(),
            'formula'        => $this->faker->optional()->sentence(),
            'meta'           => $this->faker->optional()->randomFloat(2, 10, 1000),
            'unidade_medida' => $this->faker->optional()->randomElement(['%', 'kg', 'unid', 'h']),
            'frequencia'     => $this->faker->optional()->randomElement(['Diária', 'Semanal', 'Mensal', 'Trimestral', 'Semestral', 'Anual']),
            'tipo_meta'      => $this->faker->optional()->randomElement(['Maior que', 'Menor que', 'Igual a', 'Entre']),
            'ativo'          => $this->faker->boolean(90),
        ];
    }
}

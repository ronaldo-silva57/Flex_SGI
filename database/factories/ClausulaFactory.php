<?php

namespace Database\Factories;

use App\Models\Clausula;
use App\Models\Norma;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Clausula>
 */
class ClausulaFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Clausula::class;

    public function definition(): array
    {
        return [
            'norma_id'        => Norma::factory(),
            'codigo'          => 'CL-' . $this->faker->unique()->bothify('??##'),
            'titulo'          => $this->faker->sentence(),
            'clausula_pai_id' => null,
            'ordem'           => $this->faker->numberBetween(1, 10),
            'ativo'           => true,
        ];
    }
}

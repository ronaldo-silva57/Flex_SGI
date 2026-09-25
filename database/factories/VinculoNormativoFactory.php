<?php

namespace Database\Factories;

use App\Models\Model;
use App\Models\VinculoNormativo;
use App\Models\Norma;
use App\Models\Clausula;
use App\Models\Processo;
use App\Models\Documento;
use App\Models\Indicador;
use App\Models\RiscoOportunidade;
use App\Models\RegistroLegal;
use App\Models\EsgIndicador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class VinculoNormativoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = VinculoNormativo::class;

    public function definition(): array
    {
        return [
            'norma_id' => Norma::factory(),
            'clausula_id' => Clausula::factory(),
            'processo_id' => Processo::factory(),
            'documento_id' => $this->faker->boolean(70) ? Documento::factory() : null,
            'indicador_id' => $this->faker->boolean(50) ? Indicador::factory() : null,
            'risco_id' => $this->faker->boolean(40) ? RiscoOportunidade::factory() : null,
            'requisito_legal_id' => $this->faker->boolean(30) ? RegistroLegal::factory() : null,
            'esg_indicador_id' => $this->faker->boolean(60) ? EsgIndicador::factory() : null,
            'observacao' => $this->faker->optional()->sentence(12),
        ];
    }
}

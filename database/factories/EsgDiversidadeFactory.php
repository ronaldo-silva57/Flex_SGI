<?php

namespace Database\Factories;

use App\Models\EsgDiversidade;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EsgDiversidade>
 */
class EsgDiversidadeFactory extends Factory
{
    protected $model = EsgDiversidade::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'                => Empresa::first()?->id,
            'responsavel_id'            => User::first(),
            'ano_referencia'            => $this->faker->year(),
            'categoria_cargo'           => $this->faker->randomElement(['Diretoria', 'Gerência', 'Operacional']),
            'genero'                    => $this->faker->randomElement(['Feminino', 'Masculino', 'Outro', 'Não informado']),
            'raca_etnia'                => $this->faker->randomElement(['Branco', 'Negro', 'Pardo', 'Indígena', 'Amarelo']),
            'quantidade_colaboradores'  => $this->faker->numberBetween(1, 500),
            'cargo_lideranca'           => $this->faker->boolean(30),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\ComunicacaoInterna;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComunicacaoInterna>
 */
class ComunicacaoInternaFactory extends Factory
{
    protected $model = ComunicacaoInterna::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id'    => Empresa::first()->id,
            'autor_id'      => User::first()->id,
            'titulo'        => $this->faker->sentence(4),
            'conteudo'     => $this->faker->paragraph(),
            'tipo'          => $this->faker->randomElement(['Aviso', 'Circular', 'Política SGI', 'Comunicado Oficial']),
            'exige_ciencia' => $this->faker->boolean(30),
            'publicado_em'  => $this->faker->optional()->dateTimeBetween('-1 month', 'now'),
            'expirado_em'   => $this->faker->optional()->dateTimeBetween('now', '+1 month'),
            'ativo'         => $this->faker->boolean(90),
        ];
    }
}

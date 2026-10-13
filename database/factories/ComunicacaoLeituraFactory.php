<?php

namespace Database\Factories;

use App\Models\ComunicacaoLeitura;
use App\Models\ComunicacaoInterna;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class ComunicacaoLeituraFactory extends Factory
{
    protected $model = ComunicacaoLeitura::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comunicacao_id' => ComunicacaoInterna::factory(),
            'user_id' => User::first()->id,
            'lido_em' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}

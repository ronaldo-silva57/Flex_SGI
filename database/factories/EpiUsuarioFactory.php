<?php

namespace Database\Factories;

use App\Models\EpiUsuario;
use App\Models\Epi;
use App\Models\User;    
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EpiUsuario>
 */
class EpiUsuarioFactory extends Factory
{
    protected $model = EpiUsuario::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'epi_id'                => Epi::factory(),
            'usuario_id'            => User::factory(),
            'data_entrega'          => $this->faker->date(),
            'data_vencimento'       => $this->faker->optional()->dateTimeBetween('+1 month', '+2 years'),
            'quantidade'            => $this->faker->numberBetween(1, 5),
            'responsavel_entrega_id'=> User::factory(),
            'status'                => $this->faker->randomElement(['Ativo', 'Vencido', 'Devolvido']),
        ];
    }
}

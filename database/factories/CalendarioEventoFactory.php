<?php

namespace Database\Factories;

use App\Models\CalendarioEvento;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CalendarioEvento>
 */
class CalendarioEventoFactory extends Factory
{
    protected $model = CalendarioEvento::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('+1 days', '+1 month');
        
        return [
            'empresa_id' => Empresa::first()->id,
            'responsavel_id' => User::first()->id,
            'titulo' => $this->faker->sentence(3),
            'descricao' => $this->faker->sentence(10),
            'data_inicio' => $start,
            'data_fim' => $this->faker->optional()->dateTimeBetween($start, '+2 months'),
            'dia_inteiro' => $this->faker->boolean(20),
            'categoria' => $this->faker->randomElement(['Auditoria', 'Prazo SGI', 'Reunião', 'Treinamento', 'Manutenção', 'Outros']),
            'cor' => $this->faker->hexColor(),
            'status' => $this->faker->randomElement(['Agendado', 'Realizado', 'Cancelado', 'Adiado']),
        ];
    }
}

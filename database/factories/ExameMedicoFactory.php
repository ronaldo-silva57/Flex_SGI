<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\ExameMedico;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ExameMedico>
 */
class ExameMedicoFactory extends Factory
{
    protected $model = ExameMedico::class;
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
$realizacao = fake()->dateTimeBetween('-6 months', 'now');
        $vencimento = (clone $realizacao)->modify('+1 year');

        return [
            'empresa_id' => Empresa::first()?->id ?? 1,
            'usuario_id' => User::first()?->id ?? 1,
            'medico_examinador_id' => User::first()?->id ?? 1,
            'tipo_aso' => fake()->randomElement(['Admissional', 'Periódico', 'Retorno ao Trabalho', 'Mudança de Risco', 'Demissional']),
            'data_realizacao' => $realizacao->format('Y-m-d'),
            'data_vencimento' => $vencimento->format('Y-m-d'),
            'resultado' => fake()->randomElement(['Apto', 'Apto com Restrição', 'Inapto']),
            'restricoes' => fake()->optional()->sentence(),
            'crm_medico' => fake()->numberBetween(10000, 99999) . '/SP',
            'medico_nome' => 'Dr(a). ' . fake()->name(),
            'arquivo_aso_path' => 'asos/aso_' . fake()->uuid() . '.pdf',
            'status' => 'Vigente',
        ];
    }
}

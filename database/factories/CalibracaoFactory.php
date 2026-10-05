<?php

namespace Database\Factories;

use App\Models\Calibracao;
use App\Models\EquipamentoMedicao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Calibracao>
 */
class CalibracaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
$dataCalibracao = fake()->dateTimeBetween('-6 months', 'now');
        $dataValidade = (clone $dataCalibracao)->modify('+1 year');

        return [
            'equipamento_id' => EquipamentoMedicao::first()?->id ?? 1,
            'responsavel_id' => User::first()?->id ?? 1,
            'data_calibracao' => $dataCalibracao->format('Y-m-d'),
            'data_validade' => $dataValidade->format('Y-m-d'),
            'laboratorio' => fake()->company() . ' Metrologia RBC',
            'certificado_numero' => 'CERT-' . fake()->unique()->numberBetween(10000, 99999),
            'certificado_path' => 'calibracoes/certificados/cert_' . fake()->uuid() . '.pdf',
            'resultado' => fake()->randomElement(['Aprovado', 'Aprovado com restrição', 'Reprovado']),
            'observacoes' => fake()->optional()->sentence(),
        ];
    }
}

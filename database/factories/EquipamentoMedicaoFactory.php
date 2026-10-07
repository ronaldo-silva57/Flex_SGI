<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\EquipamentoMedicao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EquipamentoMedicao>
 */
class EquipamentoMedicaoFactory extends Factory
{
    protected $model = EquipamentoMedicao::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $ultima = fake()->dateTimeBetween('-1 year', 'now');
        $proxima = (clone $ultima)->modify('+12 months');

        return [
            'empresa_id'            => Empresa::first()->id,
            'responsavel_id'        => User::first()?->id ?? 1,
            'codigo'                => 'EQ-' . fake()->unique()->numberBetween(100, 999),
            'nome'                  => fake()->randomElement(['Paquímetro Digital 150mm', 'Micrômetro Externo 0-25mm', 'Termohigrômetro', 'Balança Analítica', 'Multímetro Digital']),
            'marca'                 => fake()->randomElement(['Mitutoyo', 'Starrett', 'Toledo', 'Fluke', 'Mettler Toledo']),
            'modelo'                => fake()->bothify('MOD-###??'),
            'numero_serie'          => fake()->bothify('SN-######'),
            'faixa_medicao'         => '0 a 150 mm / 0,01 mm',
            'resolucao'             => '0.01 mm',
            'localizacao'           => fake()->randomElement(['Laboratório CQ', 'Linha 01 - Montagem', 'Sala Limpa', 'Recebimento']),
            'periodicidade_calibracao_meses' => 12,
            'ultima_calibracao'     => $ultima->format('Y-m-d'),
            'proxima_calibracao'    => $proxima->format('Y-m-d'),
            'status'                => fake()->randomElement(['Ativo', 'Em manutenção', 'Inativo', 'Descartado']),
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\IndicadorAmbiental;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IndicadorAmbiental>
 */
class IndicadorAmbientalFactory extends Factory
{
    protected $model = IndicadorAmbiental::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
return [
            'empresa_id' => Empresa::first()?->id ?? 1,
            'responsavel_id' => User::first()?->id ?? 1,
            'codigo' => 'IND-AMB-' . fake()->unique()->numberBetween(10, 99),
            'nome' => fake()->randomElement(['Consumo de Água Potável', 'Geração de Resíduos Industriais', 'Consumo Específico de Energia', 'Emissões CO2 Equivalente']),
            'descricao' => 'Mede e acompanha a eficiência ambiental das operações no período.',
            'categoria' => fake()->randomElement(['Emissões Atmosféricas', 'Recursos Hídricos', 'Energia', 'Resíduos', 'Biodiversidade', 'Uso do Solo', 'Ruído', 'Outros']),
            'formula' => '(Consumo Total de Água / Volume Produzido)',
            'meta' => fake()->randomFloat(2, 10, 500),
            'unidade_medida' => fake()->randomElement(['m3/mês', 'kWh/unid', 'kg/unid', 'tCO2e']),
            'frequencia' => fake()->randomElement(['Mensal', 'Trimestral', 'Semestral', 'Anual']),
            'tipo_meta' => fake()->randomElement(['Maior que', 'Menor que', 'Igual a', 'Entre']),
            'ativo' => true,
        ];
    }
}

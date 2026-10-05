<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\GestaoResiduo;
use App\Models\Processo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<GestaoResiduo>
 */
class GestaoResiduoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
return [
            'empresa_id' => Empresa::first()?->id ?? 1,
            'processo_id' => Processo::first()?->id,
            'responsavel_id' => User::first()?->id ?? 1,
            'codigo' => 'RES-' . fake()->unique()->numberBetween(100, 999),
            'descricao' => fake()->randomElement(['Tampões e Óleo Usado', 'Aparas de Papel e Papelão', 'Retalhos Metálicos', 'Lodo ETE', 'Lâmpadas Fluorescentes']),
            'classe' => fake()->randomElement(['Classe I', 'Classe II-A', 'Classe II-B']),
            'tipo' => fake()->randomElement(['Reciclável', 'Não reciclável', 'Perigoso', 'Inerte', 'Orgânico', 'Outros']),
            'fonte_geradora' => 'Usinagem e Manutenção Mecânica',
            'quantidade_gerada' => fake()->randomFloat(3, 10, 5000),
            'unidade_medida' => fake()->randomElement(['kg', 't', 'm3', 'L']),
            'frequencia_geracao' => fake()->randomElement(['Diária', 'Semanal', 'Mensal', 'Trimestral', 'Semestral', 'Anual', 'Esporádica']),
            'forma_armazenamento' => 'Tambores identificados em abrigo coberto com bacia de contenção.',
            'destino_final' => fake()->randomElement(['Reutilização', 'Reciclagem', 'Coprocessamento', 'Aterro Industrial', 'Aterro Sanitário', 'Incineração', 'Compostagem', 'Outros']),
            'transportador' => fake()->company() . ' Transportes Ambientais',
            'destinador' => fake()->company() . ' Soluções Ambientais Ltda',
            'numero_mtr' => 'MTR-' . fake()->numberBetween(10000, 99999),
            'observacoes' => fake()->optional()->sentence(),
            'status' => 'Ativo',
        ];
    }
}

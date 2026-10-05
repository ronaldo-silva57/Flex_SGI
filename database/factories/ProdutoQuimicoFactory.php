<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Fornecedor;
use App\Models\ProdutoQuimico;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProdutoQuimico>
 */
class ProdutoQuimicoFactory extends Factory
{
    protected $model = ProdutoQuimico::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
return [
            'empresa_id' => Empresa::first()?->id ?? 1,
            'fornecedor_id' => Fornecedor::first()?->id,
            'responsavel_id' => User::first()?->id ?? 1,
            'nome' => fake()->randomElement(['Solvente Desengraxante S-10', 'Óleo Lubrificante ISO VG 68', 'Ácido Sulfúrico 98%', 'Detergente Industrial Neutro']),
            'fabricante' => fake()->company(),
            'numero_fispq' => 'FISP-2026/' . fake()->numberBetween(100, 999),
            'numero_cas' => fake()->numberBetween(100, 999) . '-' . fake()->numberBetween(10, 99) . '-' . fake()->numberBetween(1, 9),
            'estado_fisico' => fake()->randomElement(['Sólido', 'Líquido', 'Gasoso', 'Pastoso', 'Outros']),
            'composicao' => 'Mistura de hidrocarbonetos alifáticos e aditivos anticorrosivos.',
            'perigos_ghs' => 'H304 - Pode ser fatal se ingerido e penetrar nas vias respiratórias. H315 - Provoca irritação à pele.',
            'palavra_advertencia' => fake()->randomElement(['Perigo', 'Atenção']),
            'pictogramas' => 'Inflamável, Corrosivo, Perigo à Saúde',
            'primeiros_socorros' => 'Em caso de contato com os olhos, lavar com água em abundância por 15 minutos.',
            'combate_incendio' => 'Utilizar pó químico seco (PQS) ou dióxido de carbono (CO2).',
            'medidas_derramamento' => 'Isolar a área, estancar o vazamento e absorver com areia ou vermiculita.',
            'manuseio_armazenamento' => 'Armazenar em local fresco, ventilado e afastado de fontes de ignição.',
            'epi_necessario' => 'Óculos de proteção, luvas de nitrila e avental de PVC.',
            'epc_necessario' => 'Lava-olhos de emergência e chuveiro de segurança.',
            'localizacao' => 'Almoxarifado de Produtos Químicos - Baia 02',
            'quantidade_estoque' => fake()->randomFloat(3, 5, 200),
            'unidade_medida' => fake()->randomElement(['L', 'kg', 'Galão 20L']),
            'data_validade' => fake()->dateTimeBetween('+6 months', '+2 years')->format('Y-m-d'),
            'arquivo_fispq_path' => 'fispq/fispq_' . fake()->uuid() . '.pdf',
            'status' => 'Ativo',
        ];
    }
}

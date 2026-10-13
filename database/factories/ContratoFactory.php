<?php

namespace Database\Factories;

use App\Models\Contrato;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\Fornecedor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Contrato>
 */
class ContratoFactory extends Factory
{
    protected $model = Contrato::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::first()->id,
            'cliente_id' => Cliente::factory(),
            'fornecedor_id' => Fornecedor::factory(),
            'responsavel_id' => User::factory(),
            'numero_contrato' => $this->faker->unique()->bothify('CT-####'),
            'titulo' => $this->faker->sentence(3),
            'tipo' => $this->faker->randomElement(['Cliente', 'Fornecedor', 'Parceria', 'Prestação de Serviço']),
            'valor_total' => $this->faker->randomFloat(2, 1000, 50000),
            'data_inicio' => $this->faker->date(),
            'data_fim' => $this->faker->dateTimeBetween('+1 month', '+2 years'),
            'alerta_vencimento_dias' => $this->faker->numberBetween(15, 60),
            'status' => $this->faker->randomElement(['Minuta', 'Vingente', 'Suspenso', 'Encerrado', 'Recindido']),
            'objeto' => $this->faker->sentence(12),
            'observacoes' => $this->faker->optional()->sentence(8),
            'arquivo_path' => null,
        ];
    }
}

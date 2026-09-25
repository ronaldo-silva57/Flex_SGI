<?php

namespace Database\Factories;

use App\Models\ControleSeguranca;
use App\Models\Empresa;
use App\Models\AtivoInformacao;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ControleSeguranca>
 */
class ControleSegurancaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = ControleSeguranca::class;

    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::first()->id,
            'ativo_id' => AtivoInformacao::factory(), // opcional
            'codigo_anexo_a' => $this->faker->regexify('[A-Z]{2}[0-9]{3}'),
            'titulo' => $this->faker->sentence(4),
            'descricao' => $this->faker->paragraph(),
            'implementado' => $this->faker->boolean(),
            'evidencia' => $this->faker->optional()->text(200),
            'responsavel_id' => User::first()->id, 
            'data_implementacao' => $this->faker->optional()->date(),
        ];
    }
}

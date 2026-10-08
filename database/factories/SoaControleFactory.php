<?php

namespace Database\Factories;

use App\Models\SoaControle;
use App\Models\Empresa;
use App\Models\User;
use App\Models\ControleSeguranca;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SoaControle>
 */
class SoaControleFactory extends Factory
{
    protected $model = SoaControle::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::first()->id,
            'responsavel_id' => User::first()->id,

            'codigo_anexo_a' => $this->faker->unique()->regexify('A\.[0-9]{1,2}\.[0-9]{1,2}'),
            'dominio' => $this->faker->randomElement([
                'Políticas de SI',
                'Organização da Segurança',
                'Gestão de Ativos',
                'Controle de Acesso'
            ]),
            'titulo' => $this->faker->sentence(3),
            'descricao' => $this->faker->paragraph(),

            'aplicavel' => $this->faker->boolean(),
            'justificativa_inclusao' => $this->faker->sentence(),
            'justificativa_exclusao' => null,
            'status_implementacao' => $this->faker->randomElement([
                'Não iniciado','Em implementacao','Implementado','Não aplicável'
            ]),
            'evidencia_path' => null,
            'controle_id' => ControleSeguranca::first()->id,
        ];
    }
}

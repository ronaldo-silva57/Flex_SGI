<?php

namespace Database\Factories;

use App\Models\IncidenteSeguranca;
use App\Models\Empresa;
use App\Models\AtivoInformacao;
use App\Models\User;
use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class IncidenteSegurancaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = IncidenteSeguranca::class;
    
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::first()->id,
            'ativo_id' => AtivoInformacao::inRandomOrder()->first()?->id,
            'responsavel_id' => User::first()->id,
            'data_ocorrencia' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'tipo' => $this->faker->randomElement([
                'Acesso não autorizado', 'Malware', 'Vazamento Dados', 
                'Indisponibilidade', 'Phishing', 'Outros'
            ]),
            'descricao' => $this->faker->paragraph(2),
            'impacto' => $this->faker->sentence(),
            'acao_imediata' => $this->faker->sentence(),
            'investigacao' => $this->faker->paragraph(1),
            'status' => $this->faker->randomElement(['Aberto', 'Em investigação', 'Concluído']),
        ];
    }
}

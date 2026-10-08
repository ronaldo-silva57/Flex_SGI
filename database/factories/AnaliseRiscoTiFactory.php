<?php

namespace Database\Factories;

use App\Models\AnaliseRiscoTi;
use App\Models\Empresa;
use App\Models\User;
use App\Models\AtivoInformacao;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnaliseRiscoTiFactory extends Factory
{
    protected $model = AnaliseRiscoTi::class;

    public function definition(): array
    {
        $prob = $this->faker->numberBetween(1, 5);
        $impacto = $this->faker->numberBetween(1, 5);

        return [
            'empresa_id' => Empresa::first()->id, 
            'ativo_id' => AtivoInformacao::first()->id, 
            'responsavel_id' => User::first()->id, 

            'ameaca' => $this->faker->words(3, true),
            'vulnerabilidade' => $this->faker->words(3, true),

            'afeta_confidencialidade' => $this->faker->boolean(),
            'afeta_integridade' => $this->faker->boolean(),
            'afeta_disponibilidade' => $this->faker->boolean(),

            'probabilidade' => $prob,
            'impacto' => $impacto,
            // nivel_risco_inerente é calculado pelo banco (storedAs)

            'controles_existentes' => $this->faker->sentence(),
            'opcao_tratamento' => $this->faker->randomElement(['Mitigar','Transferir','Evitar','Aceitar']),
            'plano_tratamento' => $this->faker->paragraph(),

            'probabilidade_residual' => $this->faker->numberBetween(1, 5),
            'impacto_residual' => $this->faker->numberBetween(1, 5),
            // nivel_risco_residual também é calculado pelo banco

            'status' => $this->faker->randomElement(['Identificado','Em tratamento','Monitorado','Encerrado']),
        ];
    }
}

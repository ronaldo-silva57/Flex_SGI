<?php

namespace Database\Factories;

use App\Models\NaoConformidadeAmbiental;
use App\Models\Empresa;
use App\Models\User;
use App\Models\LicencaAmbiental;
use App\Models\AspectoAmbiental;
use App\Models\Processo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NaoConformidadeAmbiental>
 */
class NaoConformidadeAmbientalFactory extends Factory
{
    protected $model = NaoConformidadeAmbiental::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::factory(),
            'licenca_ambiental_id' => LicencaAmbiental::factory(),
            'aspecto_ambiental_id' => AspectoAmbiental::factory(),
            'processo_id' => Processo::factory(),
            'responsavel_apuracao_id' => User::factory(),
            'responsavel_tratamento_id' => User::factory(),

            'codigo' => $this->faker->unique()->numerify('NC-###'),
            'titulo' => $this->faker->sentence(3),
            'origem' => $this->faker->randomElement([
                'Auditoria','Fiscalização','Monitoramento','Reclamação','Incidente','Outros'
            ]),
            'local_ocorrencia' => $this->faker->city(),
            'descricao' => $this->faker->paragraph(),
            'requisito_nao_atendido' => $this->faker->sentence(),
            'evidencia_inicial' => $this->faker->sentence(),
            'gravidade' => $this->faker->randomElement(['Baixa','Média','Alta','Crítica']),
            'probabilidade' => $this->faker->randomElement(['Baixa','Média','Alta']),
            'prioridade' => $this->faker->randomElement(['Baixa','Média','Alta']),
            'recorrente' => $this->faker->boolean(),
            'status' => 'Aberta',

            'data_identificacao' => $this->faker->date(),
            'data_abertura' => now()->toDateString(),
            'prazo_tratamento' => $this->faker->date(),
            'data_analise' => null,
            'data_verificacao' => null,
            'data_encerramento' => null,
            'justificativa_encerramento' => null,
            'acao_corretiva' => null,
        ];
    }
}

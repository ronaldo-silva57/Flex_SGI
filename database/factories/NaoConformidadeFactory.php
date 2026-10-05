<?php

namespace Database\Factories;

use App\Models\NaoConformidade;
use App\Models\Empresa;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Norma;
use App\Models\Clausula;
use App\Models\Processo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NaoConformidade>
 */
class NaoConformidadeFactory extends Factory
{
    protected $model = NaoConformidade::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::factory(),
            'cliente_id' => Cliente::factory(),
            'norma_id' => Norma::factory(),
            'clausula_id' => Clausula::factory(),
            'processo_id' => Processo::factory(),
            'responsavel_apuracao_id' => User::factory(),
            'responsavel_tratamento_id' => User::factory(),

            'codigo' => $this->faker->unique()->numerify('NC-2026-####'),
            'titulo' => $this->faker->sentence(4),
            'tipo' => 'Não Conformidade',
            'origem' => $this->faker->randomElement(['Auditoria','Monitoramento','Reclamacao','Incidente','Outros']),
            'local_ocorrencia' => $this->faker->city(),

            'descricao' => $this->faker->paragraph(),
            'requisito_nao_atendido' => $this->faker->sentence(),
            'evidencia_inicial' => $this->faker->sentence(),
            'gravidade' => $this->faker->randomElement(['Baixa','Media','Alta','Crítica']),
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
        ];
    }
}

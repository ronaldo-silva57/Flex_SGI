<?php

namespace Database\Factories;

use App\Models\Processo;
use App\Models\Empresa;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProcessoFactory extends Factory
{
    protected $model = Processo::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::firstOrCreate([
                'id' => 1,
            ])->id,

            'departamento_id' => Departamento::inRandomOrder()->value('id'),

            'responsavel_id' => User::first()?->id,

            'codigo' => 'PROC-' . fake()->unique()->numerify('####'),

            'nome' => fake()->randomElement([
                'Gestão de Compras',
                'Gestão de Vendas',
                'Gestão de Recursos Humanos',
                'Gestão Financeira',
                'Controle de Documentos',
                'Gestão da Qualidade',
                'Controle de Estoque',
                'Atendimento ao Cliente',
                'Avaliação de Fornecedores',
                'Auditoria Interna',
                'Gestão de Não Conformidades',
                'Manutenção de Equipamentos',
                'Gestão Ambiental',
                'Gestão de Segurança',
                'Planejamento Estratégico',
            ]),

            'descricao' => fake()->paragraph(),

            'objetivo' => fake()->sentence(12),

            'entradas' => fake()->randomElement([
                'Pedidos de clientes, informações de estoque e requisitos aplicáveis.',
                'Solicitações internas e requisitos dos processos.',
                'Documentos, registros e informações das áreas envolvidas.',
                'Dados de clientes, fornecedores e demais partes interessadas.',
            ]),

            'saidas' => fake()->randomElement([
                'Produto ou serviço entregue conforme requisitos.',
                'Relatórios e registros do processo.',
                'Informações disponibilizadas às partes interessadas.',
                'Pedidos processados e aprovados.',
                'Indicadores e resultados do processo.',
            ]),

            'indicadores_chave' => fake()->randomElement([
                'Prazo de atendimento, índice de retrabalho e satisfação do cliente.',
                'Taxa de conformidade, tempo médio e produtividade.',
                'Número de ocorrências, prazo de solução e eficácia.',
                'Custo, prazo e qualidade.',
            ]),

            'tipo' => fake()->randomElement([
                'Estratégico',
                'Principal',
                'Apoio',
            ]),

            'ativo' => fake()->boolean(90),
        ];
    }
}
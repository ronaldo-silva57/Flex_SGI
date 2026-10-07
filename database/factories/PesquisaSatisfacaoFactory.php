<?php

namespace Database\Factories;

use App\Models\PesquisaSatisfacao;
use App\Models\Empresa;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PesquisaSatisfacaoFactory extends Factory
{
    protected $model = PesquisaSatisfacao::class;

    public function definition(): array
    {
        return [
            'empresa_id'        => Empresa::first()->id ?? 1,
            'cliente_id'        => Cliente::first()->id ?? null,
            'responsavel_id'    => User::first()->id ?? null,
            'codigo'            => strtoupper($this->faker->bothify('PS-####')),
            'titulo'            => $this->faker->sentence(4),
            'descricao'         => $this->faker->paragraph(),
            'tipo'              => $this->faker->randomElement(['NPS', 'CSAT', 'Personalizada']),
            'canal'             => $this->faker->randomElement(['Email', 'Telefone', 'Presencial', 'Online']),
            'data_inicio'       => $this->faker->date(),
            'data_fim'          => $this->faker->optional()->date(),
            'status'            => $this->faker->randomElement(['Planejada', 'Em andamento', 'Concluída', 'Cancelada']),
            'nota_media'        => $this->faker->optional()->randomFloat(2, 0, 10),
            'total_respostas'   => $this->faker->numberBetween(0, 100),
        ];
    }
}

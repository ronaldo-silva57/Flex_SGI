<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\PesquisaSatisfacao;
use App\Models\PesquisaSatisfacaoResposta;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PesquisaSatisfacaoResposta>
 */
class PesquisaSatisfacaoRespostaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
$nota = fake()->randomFloat(2, 1, 10);
        $classificacao = $nota >= 9 ? 'Promotor' : ($nota >= 7 ? 'Neutro' : 'Detrator');

        return [
            'pesquisa_id' => PesquisaSatisfacao::first()?->id ?? 1,
            'cliente_id' => Cliente::first()?->id,
            'respondente_id' => User::first()?->id ?? 1,
            'nota' => $nota,
            'respostas_detalhadas' => json_encode([
                'qualidade_produto' => fake()->numberBetween(1, 5),
                'tempo_entrega' => fake()->numberBetween(1, 5),
                'atendimento' => fake()->numberBetween(1, 5),
                'comentarios' => fake()->sentence(),
            ]),
            'classificacao' => $classificacao,
            'respondido_em' => now(),
        ];
    }
}

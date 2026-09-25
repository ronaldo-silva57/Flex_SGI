<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Treinamento;
use App\Models\TreinamentoUsuario;
use Illuminate\Database\Seeder;

class TreinamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Treinamento::factory(10)->create()->each(function ($treinamento) {
            TreinamentoUsuario::factory(3)->create([
                'treinamento_id' => $treinamento->id,
            ]);
        });
    }
}

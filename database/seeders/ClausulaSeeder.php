<?php

namespace Database\Seeders;

use App\Models\Clausula;
use App\Models\Norma;
use Illuminate\Database\Seeder;

class ClausulaSeeder extends Seeder
{
    public function run(): void
    {
        // Garante que existem normas para associar
        $normas = Norma::all();

        if ($normas->isEmpty()) {
            $normas = Norma::factory(3)->create();
        }

        foreach ($normas as $norma) {
            // Cria 3 cláusulas principais
            $pais = Clausula::factory(3)->create([
                'norma_id' => $norma->id,
            ]);

            // Cria subcláusulas para cada pai
            foreach ($pais as $pai) {
                Clausula::factory(2)->create([
                    'norma_id' => $norma->id,
                    'clausula_pai_id' => $pai->id,
                ]);
            }
        }
    }
}
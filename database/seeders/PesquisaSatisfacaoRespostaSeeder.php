<?php

namespace Database\Seeders;

use App\Models\PesquisaSatisfacaoResposta;
use Illuminate\Database\Seeder;

class PesquisaSatisfacaoRespostaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PesquisaSatisfacaoResposta::factory()->count(50)->create();
    }
}

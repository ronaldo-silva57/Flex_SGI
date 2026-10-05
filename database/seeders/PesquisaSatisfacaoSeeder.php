<?php

namespace Database\Seeders;

use App\Models\PesquisaSatisfacao;
use Illuminate\Database\Seeder;

class PesquisaSatisfacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PesquisaSatisfacao::factory()->count(25)->create();
    }
}

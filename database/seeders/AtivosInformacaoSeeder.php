<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AtivoInformacao;

class AtivosInformacaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AtivoInformacao::factory(25)->create();
    }
}

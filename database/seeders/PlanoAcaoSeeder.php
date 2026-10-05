<?php

namespace Database\Seeders;

use App\Models\PlanoAcao;
use Illuminate\Database\Seeder;

class PlanoAcaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanoAcao::factory()->count(25)->create();
    }
}

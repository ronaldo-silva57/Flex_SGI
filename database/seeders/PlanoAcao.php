<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlanoAcao;

class PlanoAcao extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PlanoAcao::factory()->count(20)->create();
    }
}

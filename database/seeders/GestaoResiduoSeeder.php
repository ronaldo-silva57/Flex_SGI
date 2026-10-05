<?php

namespace Database\Seeders;

use App\Models\GestaoResiduo;
use Illuminate\Database\Seeder;

class GestaoResiduoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GestaoResiduo::factory()->count(30)->create();
    }
}

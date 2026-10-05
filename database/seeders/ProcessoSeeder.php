<?php

namespace Database\Seeders;

use App\Models\Processo;
use Illuminate\Database\Seeder;

class ProcessoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Processo::factory()->count(25)->create();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auditoria;

class AuditoriaSeeder extends Seeder
{
    public function run(): void
    {
        Auditoria::factory()->count(20)->create();
    }
}

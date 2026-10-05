<?php

namespace Database\Seeders;

use App\Models\ExameMedico;
use Illuminate\Database\Seeder;

class ExameMedicoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExameMedico::factory()->count(30)->create();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SoaControle;

class SoaControleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SoaControle::factory()->count(25)->create();
    }
}

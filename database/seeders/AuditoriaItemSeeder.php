<?php

namespace Database\Seeders;
use App\Models\AuditoriaItem;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuditoriaItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AuditoriaItem::factory()->count(15)->create();
    }
}

<?php

namespace Database\Seeders;

use App\Models\Enfant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnfantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enfant::factory()
        ->count(2)->create();
    }
}

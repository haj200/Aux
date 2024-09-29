<?php

namespace Database\Seeders;

use App\Models\Conjoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConjointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Conjoint::factory()
        ->count(16)->create();
    }
}

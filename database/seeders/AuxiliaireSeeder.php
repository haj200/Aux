<?php

namespace Database\Seeders;

use App\Models\Auxiliaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuxiliaireSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Auxiliaire::factory()
        ->count(116)->create();
    }
    
}

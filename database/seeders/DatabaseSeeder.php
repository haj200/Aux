<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Création de l'utilisateur admin
    User::factory()->create([
        'email' => 'admin@example.com',
        'role' => 'admin', // Assurez-vous que ce champ existe dans votre table 'users'
        'password' => bcrypt('admin_password'), // Définir un mot de passe
    ]);

    // Création de l'utilisateur normal
    User::factory()
        ->count(116)->create();
}

}

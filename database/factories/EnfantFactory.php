<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enfant>
 */
class EnfantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Nom_Fr' => $this->faker->lastName,
            'Prenom_Fr' => $this->faker->firstName,
            'Nom_Ar' => $this->faker->randomElement(['محمد', 'أحمد', 'فاطمة', 'خديجة', 'علي']),
            'Prenom_Ar' => $this->faker->randomElement(['يوسف', 'عائشة', 'زينب', 'عمر', 'سارة']),
            'Date_De_Naissance' => $this->faker->date,
            'auxiliaire_id' => 2,
            'user_id' => 2,
            'updated_by' => 2,
        ];
    }
}

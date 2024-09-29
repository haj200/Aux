<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conjoint>
 */
class ConjointFactory extends Factory
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
            'CNIE' => $this->faker->unique()->numerify('########'),
            'auxiliaire_id' => 2,
            'user_id' => 2,
            'updated_by' => 2,
        ];
    }
}

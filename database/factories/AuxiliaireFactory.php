<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auxiliaire>
 */
class AuxiliaireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return  [
            'Nom_Fr' => $this->faker->lastName,
            'Prenom_Fr' => $this->faker->firstName,
            'Nom_Ar' => $this->faker->randomElement(['محمد', 'أحمد', 'فاطمة', 'خديجة', 'علي']),
            'Prenom_Ar' => $this->faker->randomElement(['يوسف', 'عائشة', 'زينب', 'عمر', 'سارة']),
            'Email' => $this->faker->unique()->safeEmail,
            'Grade' => $this->faker->word,
            'CNIE' => $this->faker->unique()->numerify('########'),
            'url_photo' => $this->faker->imageUrl(),
            'RIB' => $this->faker->bankAccountNumber,
            'date_de_naissance' => $this->faker->date,
            'date_de_recrutement' => $this->faker->date,
            'Type' => $this->faker->randomElement(['rural', 'urbain']),
            'pensionne' => $this->faker->boolean,

            'user_id' => 2,
            'updated_by' => 2,
            'entiteterritorielle_id' => 2,
        ];
    }
}

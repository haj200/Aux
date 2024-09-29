<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entiteterritorielle>
 */
class EntiteterritorielleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return 
         ['Nom' => $this->faker->word,
        'Nom_Ar' => $this->faker->randomElement(['الرباط', 'الدار البيضاء', 'فاس', 'مراكش', 'طنجة']),
        'Type' => $this->faker->randomElement(['province', 'pachalik', 'caidat', 'cercle', 'Annexe']),
        'managed_by' => 1,
        'created_by' => 1,
        'updated_by' => 1,];
    }
}

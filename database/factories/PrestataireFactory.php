<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\prestataire>
 */
class PrestataireFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'metier' => fake()->text(20),
            'disponibilite' => fake()->boolean(true),
            'user_id' => function () {
                return User::factory()->create()->id;
            }
        ];
    }
}

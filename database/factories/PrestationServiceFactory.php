<?php

namespace Database\Factories;

use App\Models\CategorieService;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PrestationService>
 */
class PrestationServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nomService' => $this->faker->text(20), // Utilisation de $this->faker au lieu de fake()
            'prestataire_id' => function () {
                return User::new()->make()->toArray();
            },
            'categorie_id' => function () {
                return CategorieService::factory()->create()->id;
            }
        ];
    }
}

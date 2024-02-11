<?php

namespace Database\Factories;

use App\Models\CategorieService;
use App\Models\prestataire;
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
        $user = User::factory()->create();
        $prestataire = prestataire::factory()->create(['user_id' => $user->id]);
        $categorieService = CategorieService::factory()->create();
        return [
            'nomService' => $this->faker->text(20),
            'presentation' => $this->faker->text(100),
            'experience' => $this->faker->text(100),
            'competence' => $this->faker->text(100),
            'motivation' => $this->faker->text(100),
            'prestataire_id' => $prestataire->id,
            'categorie_id' => $categorieService->id,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\client;
use App\Models\Prestation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $client = client::factory()->create(['user_id' => $user->id]);
        $prestation = Prestation::factory()->create();
        return [
            'client_id' => $client->id,
            'prestation_id' => $prestation->id,
            'statut_evaluation' => $this->faker->text(20),
        ];
    }
}

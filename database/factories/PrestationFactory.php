<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Prestation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prestation>
 */
class PrestationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => function () {
                return Client::factory()->create()->id;
            },
            'prestation_id'  => function () {
                return Prestation::factory()->create()->id;
            },
            'prestation_demande' => fake()->text(20),
        ];
    }
}

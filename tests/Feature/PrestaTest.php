<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\PrestataireFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PrestaTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_prestataire()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        $prestataire = PrestataireFactory::new()->make()->toArray();

        $response = $this->post('/api/ajouterPresta', $prestataire);

        $response->assertStatus(200);
        $response->assertJson(['message' => ' Profil prestataire ajouté avec succès']);
    }
}

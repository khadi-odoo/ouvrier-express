<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Factories\ClientFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClientTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_client()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'api');

        //$client = ClientFactory::new()->make()->toArray();

        $client = ['user_id' => 19];
        $response = $this->post('/api/ajouterclient', $client);

        $response->assertStatus(200);
        // $response->assertJson(['message' => ' Profil client ajouté avec succès']);
    }
}

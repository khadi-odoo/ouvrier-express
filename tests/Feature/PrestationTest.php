<?php

namespace Tests\Feature;

use App\Models\client as ModelsClient;
use App\Models\Prestation;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PrestationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_prestaClient()
    {

        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $client = client::factory()->create();
        $prestation = Prestation::factory()->create();
        // $prestationClient = PrestationService::factory()->create(['prestataire_id'=>1, 'categorie_id'=>1]);
        $prestationClient = ['client_id' => 2, 'prestation_id' => 1, 'prestation_demande' => 'reparation_cuisine'];
        $response = $this->post('/api/ajoutPrestation', $prestationClient);

        $response->assertStatus(200);
    }
}

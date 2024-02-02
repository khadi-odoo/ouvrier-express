<?php

namespace Tests\Feature;

use App\Models\CategorieService;
use App\Models\prestataire;
use App\Models\PrestationService;
use App\Models\User;
use Database\Factories\PrestationServiceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PrestaServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // public function test_prestaService()
    // {

    //     $user = User::factory()->create();

    //     $this->actingAs($user, 'api');

    //     $prestaS = PrestationServiceFactory::new()->make()->toArray();

    //     $response = $this->post('/api/ajoutPrestService', $prestaS);

    //     $response->assertStatus(200);
    //     $response->assertJson(['message' => ' Prestation ajoutée avec succès']);
    // }
    
    public function test_prestaService()
    {
        // $user = User::factory()->create();
        // $this->actingAs($user);

        $user = User::factory()->create();
        $this->actingAs($user,'api');

        $prestationService = PrestationService::factory()->create();
        $response = $this->post('/api/ajoutPrestService', $prestationService->toArray());

        $response->assertStatus(200);

    }
    
}

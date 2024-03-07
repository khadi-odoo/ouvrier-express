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


    public function test_prestaService()
    {

        $user = User::factory()->create();
        $this->actingAs($user, 'api');

        $prestataire = Prestataire::factory()->create();
        $categorie = CategorieService::factory()->create();
        // $prestationService = PrestationService::factory()->create(['prestataire_id'=>1, 'categorie_id'=>1]);
        $prestationService = [
            'nomService' => 'reseau',
            'presentation' => 'Je suis Maintenancier',
            'experience' => '5 ans',
            'competence' => 'Installer un réseau LAN, WAN',
            'motivation' => 'Je suis déterminé par le  perfectionnisme',
            'prestataire_id' => 2,
            'categorie_id' => 3
        ];
        $response = $this->post('/api/ajoutPrestService', $prestationService);

        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

use App\Models\CategorieService;
use App\Models\User;
use Database\Factories\CategorieServiceFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategorieTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_categorie()
    {

        $user = User::factory()->create();

        $this->actingAs($user,'api');

        // $categorie = CategorieServiceFactory::new()->make()->toArray();
        $categorie = [
            'libelleCategorie' => 'Maçonnerie',
            'description' => 'Elle contient tout ce qui est métier maçon Elle contient tout ce qui est métier maçon
            Elle contient tout ce qui est métier maçon
            Elle contient tout ce qui est métier maçon',

        ] ;
        $response = $this->post('/api/ajouterCategorie', $categorie);

        $response->assertStatus(200)->assertJson(['message' => 'Catégorie de service ajoutée avec succès']);
    }
}

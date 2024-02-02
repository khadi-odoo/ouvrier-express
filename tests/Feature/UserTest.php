<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_register()
    {
        $user = [
            'nom' => "ndoye",
            'prenom' => 'Libass',
            'tel' => '7887687',
            'adress' => 'KM city',
            'role' => 'prestataire',
            'email' => 'cisse@gmail.com',


            'password' => "passer123",
        ];

        $response = $this->post('/api/register', $user);

        $response->assertStatus(200)->assertJson(['message' => 'Utilisateur créé avec succès']);
    }

    public function test_login()
    {
        $password = "passer123";
        $user = User::create([
            'nom' => "ndoye",
            'prenom' => 'Libass',
            'tel' => '788768',
            'adress' => 'KM city',
            'role' => 'prestataire',
            'email' => 'ciss@gmail.com',


            'password' => Hash::make($password),
        ]);

        $response = $this->post('/api/login', [

            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
        $this->assertAuthenticatedAs($user, 'api');
    }

    public function test_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer' . $token])->post('/api/logout');

        $response->assertStatus(200)->assertJson(['message' => 'Utilisateur déconnecté avec succès']);
    }
}

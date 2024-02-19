<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }


    public function test_comment()
    {
        $user = User::factory()->create();
        //$this->actingAs($user, 'api');

        $commentClient = ['client_id' => 2, 'prestation_id' => 1, 'statut_evaluation' => 'Satisfait'];
        $response = $this->post('/api/ajoutComment', $commentClient);

        $response->assertStatus(200);
    }
}

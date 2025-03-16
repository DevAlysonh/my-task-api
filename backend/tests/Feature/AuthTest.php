<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    public function test_UserCanLoginWithValidCredentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK)
                ->assertJsonStructure(['token']);
    }

    public function test_UserCannotloginWithInvalidCredentials()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
                ->assertJson(['message' => 'Credenciais Inválidas']);
    }

    public function test_UserCanLogout()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $token = $response->json('token');

        $response = $this->deleteJson('/api/logout', [], [
            'Authorization' => "Bearer {$token}"
        ]);

        $response->assertStatus(Response::HTTP_OK)
                ->assertJson(['message' => 'Logout realizado com sucesso']);
    }

    public function test_UserCannotLogoutWithoutAuthentication()
    {
        $response = $this->deleteJson('/api/logout');

        $response->assertStatus(Response::HTTP_UNAUTHORIZED)
                ->assertJson(['error' => 'Unauthenticated.']);
    }
}

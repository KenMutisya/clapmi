<?php

namespace Tests\Feature\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_successfully_get_a_login_token()
    {
        $user = User::factory()->create([
                'password' => bcrypt('secret'),
        ]);

        $response = $this->post('/api/v1/user/login', [
                'email'    => $user->email,
                'password' => 'secret',
        ]);

        $response->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_correct_message_when_user_provides_wrong_credentials()
    {
        $response = $this->post('/api/v1/user/login', [
                'email'    => 'notavailable@example.com',
                'password' => 'secret',
        ]);
        $response->assertJsonStructure([
                'error',
        ]);
    }
}
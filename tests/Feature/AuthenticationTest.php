<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testLoginSuccessfully()
    {
        $user = User::create([
            'id'       => '1',
            'name'     => 'Sakai Moka',
            'username' => 'moka',
            'password' => Hash::make('moka!'),
            'role'     => 'owner',
        ]);

        $credentials = [
            'username' => 'moka',
            'password' => 'moka!',
        ];

        $response = $this->post('/login/auth', $credentials);
        $response->assertStatus(302);
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function testLoginFailed()
    {
        $credentials = [
            'username' => 'rei',
            'password' => 'naoi',
        ];

        $response = $this->post('/login/auth', $credentials);
        $response->assertStatus(302);
        $response->assertSessionHasErrors(['loginError']);
    }

    public function testLogoutSuccessfully()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/logout');
        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }
}

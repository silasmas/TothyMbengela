<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    public function test_users_can_authenticate_via_email_otp(): void
    {
        $user = User::factory()->create(['email' => 'otp-user@example.com']);
        $email = strtolower($user->email);
        $code = '123456';
        Cache::put('auth_otp:'.$email, [
            'hash' => Hash::make($code),
            'intent' => 'login',
            'name' => null,
        ], now()->addMinutes(15));

        $response = $this->postJson('/login/verify', [
            'email' => $user->email,
            'code' => $code,
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_users_cannot_login_with_wrong_otp(): void
    {
        $user = User::factory()->create(['email' => 'wrong@example.com']);
        $email = strtolower($user->email);
        Cache::put('auth_otp:'.$email, [
            'hash' => Hash::make('999999'),
            'intent' => 'login',
            'name' => null,
        ], now()->addMinutes(15));

        $this->postJson('/login/verify', [
            'email' => $user->email,
            'code' => '000000',
        ])->assertStatus(422);

        $this->assertGuest();
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}

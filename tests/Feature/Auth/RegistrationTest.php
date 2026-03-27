<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_via_email_otp(): void
    {
        Mail::fake();

        $this->postJson('/register/send-code', [
            'name' => 'Test User',
            'email' => 'newuser@example.com',
        ])->assertOk()->assertJson(['success' => true]);

        $email = 'newuser@example.com';
        $code = '654321';
        Cache::put('auth_otp:'.$email, [
            'hash' => Hash::make($code),
            'intent' => 'register',
            'name' => 'Test User',
        ], now()->addMinutes(15));

        $response = $this->postJson('/register/verify', [
            'email' => $email,
            'code' => $code,
        ]);

        $response->assertOk();
        $response->assertJson(['success' => true]);
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => $email, 'name' => 'Test User']);
    }
}

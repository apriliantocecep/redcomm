<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class LogoutTest extends TestCase
{
    /**
     * Logout action unauthorized
     */
    public function test_user_logout_unauthorized()
    {
        $this->postJson('/api/auth/logout', ['Accept' => 'application/json'])
            ->assertUnauthorized()
            ->assertJson([
                "error" => true,
                "data" => [
                    "message" => "Unauthenticated.",
                ]
            ]);
    }

    /**
     * Logout action success
     */
    public function test_user_logout_success()
    {
        $user = \App\Models\User::factory()->create();
        // $this->actingAs($user, 'api');
        $token = JWTAuth::fromUser($user);

        $this->postJson('/api/auth/logout', [], [
                'Accept' => 'application/json',
                'Authorization' => "Bearer $token"
            ])
            ->assertJson([
                "error" => false,
                "data" => [
                    "message" => "User successfully signed out",
                ]
            ]);
    }
}

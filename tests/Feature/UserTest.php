<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Get profile of authenticated user
     */
    public function test_get_user_profile_success(): void
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');

        $this->getJson('/api/user/profile', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "error",
                "data" => [
                    "user" => [
                        'id',
                        'name',
                        'email',
                        'email_verified_at',
                        'created_at',
                        'updated_at',
                    ],
                ]
            ]);
    }

    /**
     * Get profile unauthorized
     */
    public function test_get_user_profile_unauthorized()
    {
        $this->getJson('/api/user/profile', ['Accept' => 'application/json'])
            ->assertUnauthorized()
            ->assertJson([
                "error" => true,
                "data" => [
                    "message" => "Unauthenticated.",
                ]
            ]);
    }
}

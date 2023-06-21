<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * Test ini memastikan user memasukan email dan password.
     *
     * @return void
     */
    public function test_the_email_field_is_required()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(422)
            ->assertJson([
                "error" => true,
                "data" => [
                    "message" => "The email field is required.",
                ]
            ]);
    }

    /**
     * Test ini memastikan user sukses login
     * 
     * @return void
     */
    public function test_user_logged_in_successfull()
    {
        $user = \App\Models\User::factory()->create();

        $data = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $this->postJson('api/auth/login', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "error",
                "data" => [
                    "access_token",
                    "token_type",
                    "expires_in",
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

        $this->assertAuthenticated('api');
    }
}

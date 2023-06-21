<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    // use RefreshDatabase;

    /**
     * Tes ini memastikan bahwa semua field yang diperlukan 
     * untuk proses register diisi dengan benar.
     *
     * @return void
     */
    public function test_the_name_field_is_required()
    {
        $this->postJson('api/auth/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "error" => true,
                "data" => [
                    "message" => "The name field is required."
                ]
            ]);
    }

    /**
     * Test ini memastikan bahwa password yang di input harus sama.
     * 
     * @return void
     */
    public function test_password_confirmation_does_not_match()
    {
        $data = [
            "name" => "Cecep Aprilianto",
            "email" => "cecepaprilianto@gmail.com",
            "password" => "password",
            "password_confirmation" => "tidak sama"
        ];

        $this->postJson('api/auth/register', $data, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "error" => true,
                "data" => [
                    "message" => "The password field confirmation does not match."
                ]
            ]);
    }

    /**
     * Tes ini memastikan user berhasil di register
     * 
     * @return void
     */
    public function test_user_successfully_registered()
    {
        $data = [
            "name" => "Cecep Aprilianto",
            "email" => "cecepaprilianto@gmail.com",
            "password" => "password",
            "password_confirmation" => "password"
        ];

        $this->postJson('api/auth/register', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "error",
                "data" => [
                    "message",
                    "user" => [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                    ],
                ]
            ]);
    }
}
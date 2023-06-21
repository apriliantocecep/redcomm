<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BrandTest extends TestCase
{
    /**
     * Can get all data
     */
    public function test_can_get_all_data()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');

        \App\Models\Brand::factory(1)->create();

        $this->getJson('/api/brand', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "error",
                "data" => [
                    "current_page",
                    "data" => [
                        [
                            "id",
                            "name",
                            "description",
                            "created_at",
                            "updated_at",
                        ]
                    ],
                    "first_page_url",
                    "from",
                    "last_page",
                    "last_page_url",
                    "links",
                    "next_page_url",
                    "path",
                    "per_page",
                    "prev_page_url",
                    "to",
                    "total",
                ],
            ]);
    }

    /**
     * Can create data
     */
    public function test_can_create_data()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');

        $payload = [
            "name" => "Toyota",
            "description" => "this is brand description",
        ];

        $this->postJson('/api/brand', $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "error",
                "data" => [
                    "id",
                    "name",
                    "description",
                    "created_at",
                    "updated_at",
                ]
            ]);
    }

    /**
     * Can read data
     */
    public function test_can_read_data()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');

        $brand = \App\Models\Brand::factory()->create();

        $this->getJson('/api/brand/'.$brand->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "error",
                "data" => [
                    "id",
                    "name",
                    "description",
                    "created_at",
                    "updated_at",
                ]
            ]);
    }
    
    /**
     * Can update data
     */
    public function test_can_update_data()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');

        $brand = \App\Models\Brand::factory()->create();

        $payload = [
            "name" => "Toyota",
            "description" => "this is brand description",
        ];

        $this->putJson('/api/brand/'.$brand->id, $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "error" => false,
                "data" => [
                    "id" => $brand->id,
                    "name" => $payload['name'],
                    "description" => $payload['description'],
                ],
            ]);
    }

    /**
     * Can delete data
     */
    public function test_can_delete_data()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');

        $brand = \App\Models\Brand::factory()->create();

        $this->deleteJson('/api/brand/'.$brand->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "error" => false,
                "data" => [
                    "message" => "Selected brand has been deleted",
                ],
            ]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CarTest extends TestCase
{
    /**
     * Can get all data
     */
    public function test_can_get_all_data()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');

        \App\Models\Car::factory()->create();

        $this->getJson('/api/car', ['Accept' => 'application/json'])
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
                            "year",
                            "color",
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
        Storage::fake('photos');

        $file = UploadedFile::fake()->image('car.jpg');

        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');

        $brand = \App\Models\Brand::factory()->create();

        $payload = [
            "brand_id" => $brand->id,
            "name" => "Mobilio",
            "description" => "this is car description",
            "year" => "2023",
            "color" => "Black",
            "photos" => [
                $file,
            ],
        ];

        $this->postJson('/api/car', $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "error",
                "data" => [
                    "id",
                    "name",
                    "description",
                    "year",
                    "color",
                    "created_at",
                    "updated_at",
                ]
            ]);

            // Storage::disk('photos')->assertExists($file->hashName());
    }

    /**
     * Can read data
     */
    public function test_can_read_data()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user, 'api');

        $car = \App\Models\Car::factory()->create();

        $this->getJson('/api/car/'.$car->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "error",
                "data" => [
                    "id",
                    "name",
                    "description",
                    "year",
                    "color",
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

        $car = \App\Models\Car::factory()->create([
            'user_id' => $user->id,
        ]);

        $brand = \App\Models\Brand::factory()->create();

        $payload = [
            "brand_id" => $brand->id,
            "name" => "Mobilio",
            "description" => "this is car description",
            "year" => "2023",
            "color" => "Black",
        ];

        $this->postJson('/api/car/'.$car->id, $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "error" => false,
                "data" => [
                    "id" => $car->id,
                    "name" => $payload['name'],
                    "description" => $payload['description'],
                    "year" => $payload['year'],
                    "color" => $payload['color'],
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

        $car = \App\Models\Car::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->deleteJson('/api/car/'.$car->id, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "error" => false,
                "data" => [
                    "message" => "Selected car has been deleted",
                ],
            ]);
    }
}

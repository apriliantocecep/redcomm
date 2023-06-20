<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Photo>
 */
class PhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $car = \App\Models\Car::factory()->create();

        return [
            'car_id' => $car->id,
            // 'image' => fake()->image($directory, 360, 360, 'cars', true)
            'image' => UploadedFile::fake()->image('car.jpg', 100, 100)->store('photos'),
            // 'image' => $this->faker->image(storage_path('app/public/photos'), 50, 50, null, false),
        ];
    }
}

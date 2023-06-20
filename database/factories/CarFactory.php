<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brand = \App\Models\Brand::factory()->create();

        return [
            'brand_id' => $brand->id,
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'year' => fake()->year(),
            'color' => fake()->colorName(),
        ];
    }
}

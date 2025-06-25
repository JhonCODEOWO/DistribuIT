<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => fake()->words(2, true),
            "slug" => fake()->slug(),
            "price" => fake()->randomFloat(2, 10, 500),
            "stock" => fake()->randomDigitNotZero(1,100),
            "description" => fake()->text(100),
            "url_image" => 'placeholder.png'
        ];
    }
}

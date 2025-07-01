<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sale>
 */
class SaleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "lng"=>fake()->longitude(),
            "references" => fake()->text(),
            "lat"=>fake()->latitude(),
            "street"=>fake()->streetName(),
            "city"=>fake()->city(),
        ];
    }
}

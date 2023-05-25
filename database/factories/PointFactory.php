<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Point>
 */
class PointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => 1,
            'note' => fake()->words(3, true),
            'lat' => fake()->randomFloat(4, -90.0, 90.0),
            'lng' => fake()->randomFloat(4, -180.0, 180.0),
        ];
    }
}

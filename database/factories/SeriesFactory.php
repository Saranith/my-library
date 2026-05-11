<?php

namespace Database\Factories;

use App\Models\Series;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Series>
 */
class SeriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'synopsis' => fake()->paragraph(),
            'induction_date' => fake()->date(),
            'chapters_completed' => fake()->numberBetween(0, 100),
            'chapters_total' => fake()->numberBetween(100, 500),
            'rating' => fake()->randomFloat(1, 1, 10),
            'status' => fake()->randomElement(['Plan to Read', 'Currently Reading', 'Completed', 'On Hold', 'Dropped']),
            'type' => fake()->randomElement(['MANGA', 'MANHUA', 'MANHWA']),
        ];
    }
}

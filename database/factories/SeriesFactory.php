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
            'cover_image' => null,
            'source_link' => fake()->url(),
            'format_origin' => fake()->randomElement(['Digital Scan', 'Tankobon Physical', 'Serialization', 'Collectors Edition']),
            'induction_date' => fake()->date(),
            'chapters_completed' => fake()->numberBetween(0, 100),
            'chapters_total' => fake()->numberBetween(100, 200),
            'rating' => fake()->randomFloat(1, 1, 5),
            'status' => fake()->randomElement(['Plan to Read', 'Currently Reading', 'Completed', 'On Hold', 'Dropped']),
            'type' => fake()->randomElement(['MANGA', 'MANHUA', 'MANHWA']),
            'tags' => [fake()->word(), fake()->word()],
            'official_sources' => [fake()->url()],
        ];
    }
}

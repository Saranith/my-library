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
            'title' => $this->faker->sentence(3),
            'author' => $this->faker->name(),
            'synopsis' => $this->faker->paragraph(),
            'cover_image' => $this->faker->imageUrl(),
            'source_link' => $this->faker->url(),
            'format_origin' => 'Digital Scan',
            'induction_date' => $this->faker->date(),
            'chapters_completed' => $this->faker->numberBetween(0, 50),
            'chapters_total' => $this->faker->numberBetween(50, 100),
            'rating' => $this->faker->randomFloat(1, 1, 10),
            'status' => 'Plan to Read',
            'type' => 'MANGA',
            'tags' => ['action', 'adventure'],
            'official_sources' => ['viz'],
        ];
    }
}

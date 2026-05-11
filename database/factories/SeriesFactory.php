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
            'format_origin' => $this->faker->randomElement(['Digital Scan', 'Tankobon Physical', 'Serialization', 'Collectors Edition']),
            'induction_date' => $this->faker->date(),
            'chapters_completed' => $this->faker->numberBetween(0, 50),
            'chapters_total' => $this->faker->numberBetween(51, 100),
            'rating' => $this->faker->randomFloat(1, 1, 5),
            'status' => $this->faker->randomElement(['Plan to Read', 'Currently Reading', 'Completed', 'On Hold', 'Dropped']),
            'type' => $this->faker->randomElement(['MANGA', 'MANHUA', 'MANHWA']),
        ];
    }
}

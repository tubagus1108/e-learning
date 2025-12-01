<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => Subject::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'duration_minutes' => fake()->randomElement([30, 45, 60, 90]),
            'max_attempts' => fake()->randomElement([1, 2, 3]),
            'passing_score' => fake()->randomElement([60, 70, 75, 80]),
            'is_published' => fake()->boolean(70),
            'start_time' => fake()->dateTimeBetween('-1 week', '+1 week'),
            'end_time' => fake()->dateTimeBetween('+1 week', '+2 weeks'),
        ];
    }
}

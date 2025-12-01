<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $submitted = fake()->boolean(70);
        $graded = $submitted && fake()->boolean(50);

        return [
            'assignment_id' => Assignment::factory(),
            'student_id' => Student::factory(),
            'file_url' => $submitted ? fake()->url() : null,
            'submitted_at' => $submitted ? fake()->dateTimeBetween('-1 week', 'now') : null,
            'score' => $graded ? fake()->numberBetween(50, 100) : null,
            'feedback' => $graded ? fake()->sentence() : null,
            'graded_at' => $graded ? fake()->dateTimeBetween('-3 days', 'now') : null,
        ];
    }
}

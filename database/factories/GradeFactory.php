<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $midtermScore = fake()->randomFloat(2, 60, 95);
        $finalScore = fake()->randomFloat(2, 60, 95);
        $totalScore = ($midtermScore + $finalScore) / 2;

        $grade = match (true) {
            $totalScore >= 90 => 'A',
            $totalScore >= 80 => 'B',
            $totalScore >= 70 => 'C',
            $totalScore >= 60 => 'D',
            default => 'E',
        };

        return [
            'student_id' => Student::factory(),
            'subject_id' => Subject::factory(),
            'semester' => fake()->randomElement([1, 2]),
            'academic_year' => '2024/2025',
            'midterm_score' => $midtermScore,
            'final_score' => $finalScore,
            'total_score' => $totalScore,
            'grade' => $grade,
        ];
    }
}

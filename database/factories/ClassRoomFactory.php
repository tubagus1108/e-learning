<?php

namespace Database\Factories;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassRoom>
 */
class ClassRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gradeLevel = fake()->numberBetween(7, 9);
        $className = fake()->randomElement(['A', 'B', 'C', 'D']);

        return [
            'name' => $gradeLevel.' '.$className,
            'grade_level' => $gradeLevel,
            'homeroom_teacher_id' => Teacher::factory(),
            'academic_year' => '2024/2025',
        ];
    }
}

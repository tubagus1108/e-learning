<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AttendanceRecord>
 */
class AttendanceRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['present', 'absent', 'sick', 'permission']);

        return [
            'student_id' => Student::factory(),
            'date' => fake()->dateTimeBetween('-3 months', 'now'),
            'status' => $status,
            'notes' => $status !== 'present' ? fake()->sentence() : null,
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            ['name' => 'Matematika', 'code' => 'MTK'],
            ['name' => 'Bahasa Indonesia', 'code' => 'BIND'],
            ['name' => 'Bahasa Inggris', 'code' => 'BING'],
            ['name' => 'IPA', 'code' => 'IPA'],
            ['name' => 'IPS', 'code' => 'IPS'],
            ['name' => 'Seni Budaya', 'code' => 'SB'],
            ['name' => 'Pendidikan Jasmani', 'code' => 'PJOK'],
            ['name' => 'Pendidikan Agama', 'code' => 'PAI'],
        ];

        $subject = fake()->randomElement($subjects);
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        return [
            'name' => $subject['name'],
            'code' => $subject['code'] . fake()->numberBetween(1, 99),
            'description' => fake()->sentence(),
            'class_id' => ClassRoom::factory(),
            'teacher_id' => Teacher::factory(),
            'schedule_day' => fake()->randomElement($days),
            'schedule_time' => fake()->time('H:i'),
            'room' => 'Ruang ' . fake()->numberBetween(1, 20),
        ];
    }
}

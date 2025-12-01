<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $contentType = fake()->randomElement(['text', 'video', 'file']);

        return [
            'subject_id' => Subject::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'content_type' => $contentType,
            'file_url' => $contentType === 'file' ? fake()->url() : null,
            'video_url' => $contentType === 'video' ? fake()->url() : null,
            'content_text' => $contentType === 'text' ? fake()->paragraphs(3, true) : null,
            'order' => fake()->numberBetween(1, 20),
            'is_published' => fake()->boolean(80),
        ];
    }
}

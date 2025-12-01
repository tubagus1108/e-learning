<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\AttendanceRecord;
use App\Models\ClassRoom;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Lesson;
use App\Models\ParentModel;
use App\Models\Quiz;
use App\Models\QuizOption;
use App\Models\QuizQuestion;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User (only if doesn't exist)
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // Create Teachers with Users
        $teachers = collect();
        for ($i = 1; $i <= 10; $i++) {
            $user = User::factory()->create([
                'role' => 'teacher',
                'is_active' => true,
            ]);

            $teachers->push(Teacher::create([
                'user_id' => $user->id,
                'nip' => fake()->unique()->numerify('##########'),
                'subject_specialty' => fake()->randomElement(['Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS', 'Seni Budaya', 'Pendidikan Jasmani', 'Agama']),
                'phone' => fake()->phoneNumber(),
            ]));
        }

        // Create ClassRooms
        $classes = collect();
        foreach ([7, 8, 9] as $gradeLevel) {
            foreach (['A', 'B', 'C'] as $className) {
                $classes->push(ClassRoom::create([
                    'name' => $gradeLevel.' '.$className,
                    'grade_level' => $gradeLevel,
                    'homeroom_teacher_id' => $teachers->random()->id,
                    'academic_year' => '2024/2025',
                ]));
            }
        }

        // Create Students with Users and Parents
        $students = collect();
        foreach ($classes as $class) {
            for ($i = 1; $i <= 30; $i++) {
                $user = User::factory()->create([
                    'role' => 'student',
                    'is_active' => true,
                ]);

                $student = Student::create([
                    'user_id' => $user->id,
                    'nis' => fake()->unique()->numerify('######'),
                    'nisn' => fake()->unique()->numerify('##########'),
                    'gender' => fake()->randomElement(['male', 'female']),
                    'birth_date' => fake()->date('Y-m-d', '-10 years'),
                    'address' => fake()->address(),
                    'class_id' => $class->id,
                ]);

                $students->push($student);

                // Create Parent for each student
                $parentUser = User::factory()->create([
                    'role' => 'parent',
                    'is_active' => true,
                ]);

                ParentModel::create([
                    'user_id' => $parentUser->id,
                    'student_id' => $student->id,
                    'phone' => fake()->phoneNumber(),
                    'relationship' => fake()->randomElement(['father', 'mother', 'guardian']),
                ]);
            }
        }

        // Create Subjects for each class
        $subjects = collect();
        $subjectList = [
            ['name' => 'Matematika', 'code' => 'MTK'],
            ['name' => 'Bahasa Indonesia', 'code' => 'BIND'],
            ['name' => 'Bahasa Inggris', 'code' => 'BING'],
            ['name' => 'IPA', 'code' => 'IPA'],
            ['name' => 'IPS', 'code' => 'IPS'],
            ['name' => 'Seni Budaya', 'code' => 'SB'],
            ['name' => 'Pendidikan Jasmani', 'code' => 'PJOK'],
            ['name' => 'Pendidikan Agama', 'code' => 'PAI'],
        ];

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        foreach ($classes as $class) {
            foreach ($subjectList as $subjectData) {
                $subject = Subject::create([
                    'name' => $subjectData['name'],
                    'code' => $subjectData['code'].$class->grade_level.$class->name,
                    'description' => 'Mata pelajaran '.$subjectData['name'].' untuk kelas '.$class->name,
                    'class_id' => $class->id,
                    'teacher_id' => $teachers->random()->id,
                    'schedule_day' => fake()->randomElement($days),
                    'schedule_time' => fake()->time('H:i'),
                    'room' => 'Ruang '.fake()->numberBetween(1, 20),
                ]);

                $subjects->push($subject);

                // Enroll all students in this class to this subject
                foreach ($class->students as $student) {
                    Enrollment::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'enrolled_at' => now()->subMonths(3),
                    ]);
                }

                // Create Lessons for each subject
                for ($i = 1; $i <= 5; $i++) {
                    $contentType = fake()->randomElement(['text', 'video', 'file']);

                    Lesson::create([
                        'subject_id' => $subject->id,
                        'title' => 'Pertemuan '.$i.': '.fake()->sentence(3),
                        'description' => fake()->paragraph(),
                        'content_type' => $contentType,
                        'file_url' => $contentType === 'file' ? 'https://example.com/lesson-'.$i.'.pdf' : null,
                        'video_url' => $contentType === 'video' ? 'https://youtube.com/watch?v=example'.$i : null,
                        'content_text' => $contentType === 'text' ? fake()->paragraphs(5, true) : null,
                        'order' => $i,
                        'is_published' => true,
                    ]);
                }

                // Create Assignments
                for ($i = 1; $i <= 3; $i++) {
                    Assignment::create([
                        'subject_id' => $subject->id,
                        'title' => 'Tugas '.$i.': '.fake()->sentence(3),
                        'description' => fake()->paragraph(),
                        'due_date' => now()->addDays(7 * $i),
                        'max_score' => 100,
                        'file_url' => fake()->boolean(30) ? 'https://example.com/assignment-'.$i.'.pdf' : null,
                    ]);
                }

                // Create Quiz with Questions and Options
                $quiz = Quiz::create([
                    'subject_id' => $subject->id,
                    'title' => 'Kuis '.$subjectData['name'],
                    'description' => 'Kuis untuk menguji pemahaman materi '.$subjectData['name'],
                    'duration_minutes' => 60,
                    'max_attempts' => 2,
                    'passing_score' => 70,
                    'is_published' => true,
                    'start_time' => now()->subDays(7),
                    'end_time' => now()->addDays(7),
                ]);

                for ($q = 1; $q <= 10; $q++) {
                    $question = QuizQuestion::create([
                        'quiz_id' => $quiz->id,
                        'question_text' => 'Pertanyaan '.$q.': '.fake()->sentence().'?',
                        'question_type' => 'multiple_choice',
                        'points' => 10,
                        'order' => $q,
                    ]);

                    // Create 4 options per question
                    for ($o = 1; $o <= 4; $o++) {
                        QuizOption::create([
                            'quiz_question_id' => $question->id,
                            'option_text' => 'Opsi '.chr(64 + $o).': '.fake()->sentence(3),
                            'is_correct' => $o === 1, // First option is correct
                        ]);
                    }
                }
            }
        }

        // Create Attendance Records
        $today = now();
        for ($day = 0; $day < 30; $day++) {
            $date = $today->copy()->subDays($day);

            // Skip weekends
            if ($date->isWeekend()) {
                continue;
            }

            foreach ($students->random(50) as $student) {
                AttendanceRecord::create([
                    'student_id' => $student->id,
                    'date' => $date,
                    'status' => fake()->randomElement(['present', 'present', 'present', 'present', 'absent', 'sick', 'permission']),
                    'notes' => fake()->boolean(20) ? fake()->sentence() : null,
                ]);
            }
        }

        // Create Grades
        foreach ($students as $student) {
            foreach ($student->classRoom->subjects as $subject) {
                $midtermScore = fake()->randomFloat(2, 65, 95);
                $finalScore = fake()->randomFloat(2, 65, 95);
                $totalScore = ($midtermScore + $finalScore) / 2;

                $grade = match (true) {
                    $totalScore >= 90 => 'A',
                    $totalScore >= 80 => 'B',
                    $totalScore >= 70 => 'C',
                    $totalScore >= 60 => 'D',
                    default => 'E',
                };

                Grade::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'semester' => 1,
                    'academic_year' => '2024/2025',
                    'midterm_score' => $midtermScore,
                    'final_score' => $finalScore,
                    'total_score' => $totalScore,
                    'grade' => $grade,
                ]);
            }
        }

        // Create Announcements
        for ($i = 1; $i <= 10; $i++) {
            Announcement::create([
                'title' => fake()->sentence(),
                'content' => fake()->paragraphs(3, true),
                'author_id' => $admin->id,
                'target_role' => fake()->randomElement(['all', 'student', 'teacher', 'parent']),
                'is_published' => true,
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $quizzes = Quiz::query()
            ->whereHas('subject.classRoom.students', fn ($q) => $q->where('user_id', $user->id))
            ->with(['subject'])
            ->withCount('questions')
            ->get();

        // Load attempts for each quiz
        $quizzes->each(function ($quiz) use ($user) {
            $quiz->attempt = $quiz->attempts()->where('student_id', $user->student->id)->first();
        });

        return view('quizzes.index', compact('quizzes'));
    }

    public function show(Quiz $quiz): \Illuminate\View\View
    {
        $quiz->load('subject', 'questions');

        return view('quizzes.show', compact('quiz'));
    }

    public function take(Quiz $quiz): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // Check if already attempted
        $existingAttempt = QuizAttempt::query()
            ->where('quiz_id', $quiz->id)
            ->where('student_id', $user->student->id)
            ->first();

        if ($existingAttempt) {
            return redirect()
                ->route('quizzes.result', $quiz->id)
                ->with('info', 'You have already taken this quiz.');
        }

        $quiz->load('questions');

        return view('quizzes.take', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $validated = $request->validate([
            'answers' => 'required|array',
            'started_at' => 'required|date',
        ]);

        // Calculate score
        $quiz->load('questions');
        $correctAnswers = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $userAnswer = $validated['answers'][$question->id] ?? null;
            if ($userAnswer === $question->correct_answer) {
                $correctAnswers++;
            }
        }

        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // Calculate time taken
        $startedAt = Carbon::parse($validated['started_at']);
        $timeTaken = now()->diffInSeconds($startedAt);

        // Create quiz attempt
        QuizAttempt::create([
            'quiz_id' => $quiz->id,
            'student_id' => $user->student->id,
            'score' => $score,
            'answers' => $validated['answers'],
            'correct_answers' => $correctAnswers,
            'time_taken' => $timeTaken,
            'completed_at' => now(),
        ]);

        return redirect()
            ->route('quizzes.result', $quiz->id)
            ->with('success', 'Quiz submitted successfully!');
    }

    public function result(Quiz $quiz): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $attempt = QuizAttempt::query()
            ->where('quiz_id', $quiz->id)
            ->where('student_id', $user->student->id)
            ->firstOrFail();

        $quiz->load('subject', 'questions');

        return view('quizzes.result', compact('quiz', 'attempt'));
    }
}

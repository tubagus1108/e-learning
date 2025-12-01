<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        if ($user->student) {
            $quizzes->each(function ($quiz) use ($user) {
                $quiz->attempt = $quiz->attempts()->where('student_id', $user->student->id)->first();
            });
        }

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

        if (! $user->student) {
            return redirect()
                ->route('quizzes.index')
                ->with('error', 'Only students can take quizzes.');
        }

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

        $quiz->load('questions.options');

        return view('quizzes.take', compact('quiz'));
    }

    public function submit(Request $request, Quiz $quiz): \Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (! $user->student) {
            return redirect()
                ->route('quizzes.index')
                ->with('error', 'Only students can submit quizzes.');
        }

        try {
            $validated = $request->validate([
                'answers' => 'required|array',
                'started_at' => 'required|date',
            ]);

            // Log submitted answers for debugging
            Log::info('Quiz submission', [
                'quiz_id' => $quiz->id,
                'student_id' => $user->student->id,
                'answers' => $validated['answers'],
            ]);

            // Calculate score
            $quiz->load('questions.options');
            $correctAnswers = 0;
            $totalQuestions = $quiz->questions->count();

            foreach ($quiz->questions as $question) {
                $userAnswerOptionId = $validated['answers'][$question->id] ?? null;

                if ($userAnswerOptionId) {
                    // Check if the selected option is correct
                    $selectedOption = $question->options->firstWhere('id', $userAnswerOptionId);
                    if ($selectedOption && $selectedOption->is_correct) {
                        $correctAnswers++;
                    }
                }
            }

            $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

            // Calculate time taken
            $startedAt = Carbon::parse($validated['started_at']);
            $timeTaken = now()->diffInSeconds($startedAt);

            // Create quiz attempt
            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'student_id' => $user->student->id,
                'score' => $score,
                'answers' => $validated['answers'],
                'correct_answers' => $correctAnswers,
                'time_taken' => $timeTaken,
                'completed_at' => now(),
            ]);

            Log::info('Quiz attempt created', [
                'attempt_id' => $attempt->id,
                'score' => $score,
                'correct_answers' => $correctAnswers,
                'total_questions' => $totalQuestions,
            ]);

            return redirect()
                ->route('quizzes.result', $quiz->id)
                ->with('success', 'Quiz submitted successfully!');
        } catch (\Exception $e) {
            Log::error('Quiz submission error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('quizzes.show', $quiz->id)
                ->with('error', 'Failed to submit quiz: '.$e->getMessage());
        }
    }

    public function result(Quiz $quiz): \Illuminate\View\View|\Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if (! $user->student) {
            return redirect()
                ->route('quizzes.index')
                ->with('error', 'Only students can view quiz results.');
        }

        $attempt = QuizAttempt::query()
            ->where('quiz_id', $quiz->id)
            ->where('student_id', $user->student->id)
            ->firstOrFail();

        $quiz->load('subject', 'questions.options');

        return view('quizzes.result', compact('quiz', 'attempt'));
    }
}

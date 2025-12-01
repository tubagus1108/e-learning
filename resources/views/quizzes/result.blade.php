@extends('layouts.app')

@section('title', 'Quiz Results')

@section('content')
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
    @php
        $isPassed = $attempt->score >= 70;
    @endphp

    <!-- Results Header -->
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-8 bg-gradient-to-br {{ $isPassed ? 'from-green-500 to-emerald-600' : 'from-red-500 to-pink-600' }}">
            <div class="text-center">
                <svg class="mx-auto h-16 w-16 text-white" fill="currentColor" viewBox="0 0 20 20">
                    @if($isPassed)
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                    @else
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                    @endif
                </svg>
                <h1 class="mt-4 text-3xl font-bold text-white">
                    {{ $isPassed ? 'Congratulations!' : 'Not Passed' }}
                </h1>
                <p class="mt-2 text-lg text-white/90">{{ $quiz->title }}</p>
            </div>
        </div>

        <div class="px-6 py-6">
            <div class="grid grid-cols-3 gap-4">
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-3xl font-bold {{ $isPassed ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ $attempt->score }}%
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Your Score</div>
                </div>
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ $attempt->correct_answers }}/{{ $quiz->questions->count() }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Correct Answers</div>
                </div>
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-3xl font-bold text-indigo-600 dark:text-indigo-400">
                        {{ gmdate('i:s', $attempt->time_taken) }}
                    </div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Time Taken</div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-center gap-4">
                <a href="{{ route('quizzes.index') }}" class="rounded-md bg-white dark:bg-gray-700 px-4 py-2.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                    Back to Quizzes
                </a>
                <a href="{{ route('subjects.show', $quiz->subject_id) }}" class="rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                    Back to Subject
                </a>
            </div>
        </div>
    </div>

    <!-- Answer Review -->
    <div class="space-y-4">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Answer Review</h2>
        
        @foreach($quiz->questions as $index => $question)
            @php
                $userAnswerOptionId = $attempt->answers[$question->id] ?? null;
                $userAnswerOption = $question->options->firstWhere('id', $userAnswerOptionId);
                $correctOption = $question->options->firstWhere('is_correct', true);
                $isCorrect = $userAnswerOption && $userAnswerOption->is_correct;
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div class="flex items-start justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Question {{ $index + 1 }}
                    </h3>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $isCorrect ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' }}">
                        {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                    </span>
                </div>

                <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $question->question_text }}</p>

                <div class="space-y-2">
                    @foreach($question->options as $option)
                        @php
                            $isUserAnswer = $userAnswerOption && $userAnswerOption->id === $option->id;
                            $isCorrectAnswer = $option->is_correct;
                        @endphp
                        <div class="flex items-start p-3 rounded-lg {{ $isCorrectAnswer ? 'bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800' : ($isUserAnswer ? 'bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800' : 'bg-gray-50 dark:bg-gray-700') }}">
                            <span class="flex-1 {{ $isCorrectAnswer ? 'text-green-700 dark:text-green-300' : ($isUserAnswer ? 'text-red-700 dark:text-red-300' : 'text-gray-700 dark:text-gray-300') }}">
                                {{ $option->option_text }}
                                @if($isCorrectAnswer)
                                    <svg class="inline h-4 w-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-medium ml-1">(Correct Answer)</span>
                                @elseif($isUserAnswer)
                                    <svg class="inline h-4 w-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="text-xs font-medium ml-1">(Your Answer)</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>

                @if(!$userAnswerOption)
                    <div class="mt-3 text-sm text-red-600 dark:text-red-400">
                        <strong>You did not answer this question</strong>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection

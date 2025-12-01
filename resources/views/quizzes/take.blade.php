@extends('layouts.app')

@section('title', 'Taking Quiz: ' . $quiz->title)

@section('content')
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
    <!-- Timer Bar -->
    <div class="sticky top-0 z-10 mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Time Remaining:</div>
                <div id="timer" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $quiz->time_limit }}:00</div>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Question <span id="currentQuestion">1</span> of {{ $quiz->questions->count() }}
            </div>
        </div>
        <div class="mt-3 h-2 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
            <div id="timeBar" class="h-full bg-indigo-600 dark:bg-indigo-500 transition-all duration-1000" style="width: 100%"></div>
        </div>
    </div>

    <form id="quizForm" action="{{ route('quizzes.submit', $quiz->id) }}" method="POST">
        @csrf
        <input type="hidden" name="started_at" value="{{ now()->toIso8601String() }}">

        <!-- Questions -->
        <div id="questionsContainer">
            @foreach($quiz->questions as $index => $question)
                <div class="question-card mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6 {{ $index > 0 ? 'hidden' : '' }}" data-question="{{ $index + 1 }}">
                    <div class="flex items-start justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Question {{ $index + 1 }}
                        </h3>
                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900/20 dark:text-indigo-400">
                            {{ ucfirst($question->type) }}
                        </span>
                    </div>

                    <p class="text-base text-gray-700 dark:text-gray-300 mb-6">{{ $question->question_text }}</p>

                    @if($question->type === 'multiple_choice')
                        <div class="space-y-3">
                            @foreach(json_decode($question->options) as $optionIndex => $option)
                                <label class="flex items-start p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                    <input 
                                        type="radio" 
                                        name="answers[{{ $question->id }}]" 
                                        value="{{ chr(65 + $optionIndex) }}"
                                        class="mt-0.5 h-4 w-4 text-indigo-600 focus:ring-indigo-600 dark:bg-gray-700 dark:border-gray-600"
                                        required
                                    >
                                    <span class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                        <span class="font-medium">{{ chr(65 + $optionIndex) }}.</span> {{ $option }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    @elseif($question->type === 'true_false')
                        <div class="space-y-3">
                            <label class="flex items-start p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <input 
                                    type="radio" 
                                    name="answers[{{ $question->id }}]" 
                                    value="True"
                                    class="mt-0.5 h-4 w-4 text-indigo-600 focus:ring-indigo-600 dark:bg-gray-700 dark:border-gray-600"
                                    required
                                >
                                <span class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">True</span>
                            </label>
                            <label class="flex items-start p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <input 
                                    type="radio" 
                                    name="answers[{{ $question->id }}]" 
                                    value="False"
                                    class="mt-0.5 h-4 w-4 text-indigo-600 focus:ring-indigo-600 dark:bg-gray-700 dark:border-gray-600"
                                    required
                                >
                                <span class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">False</span>
                            </label>
                        </div>
                    @endif

                    <!-- Navigation Buttons -->
                    <div class="mt-6 flex items-center justify-between">
                        <button 
                            type="button" 
                            onclick="previousQuestion()"
                            class="inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-3.5 py-2.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 {{ $index === 0 ? 'invisible' : '' }}"
                        >
                            <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                            Previous
                        </button>
                        
                        @if($index < $quiz->questions->count() - 1)
                            <button 
                                type="button" 
                                onclick="nextQuestion()"
                                class="inline-flex items-center rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500"
                            >
                                Next
                                <svg class="ml-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </button>
                        @else
                            <button 
                                type="button"
                                onclick="submitQuiz()"
                                class="inline-flex items-center rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-500"
                            >
                                <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                </svg>
                                Submit Quiz
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </form>
</div>

@push('scripts')
<script>
let currentQuestion = 1;
let totalQuestions = {{ $quiz->questions->count() }};
let timeLimit = {{ $quiz->time_limit * 60 }}; // Convert to seconds
let timeRemaining = timeLimit;
let timerInterval;

// Start timer on page load
window.addEventListener('load', function() {
    startTimer();
});

// Warn before leaving page
window.addEventListener('beforeunload', function (e) {
    e.preventDefault();
    e.returnValue = '';
});

function startTimer() {
    timerInterval = setInterval(function() {
        timeRemaining--;
        updateTimerDisplay();
        updateTimeBar();
        
        if (timeRemaining <= 0) {
            clearInterval(timerInterval);
            alert('Time is up! Your quiz will be submitted automatically.');
            document.getElementById('quizForm').submit();
        }
    }, 1000);
}

function updateTimerDisplay() {
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;
    document.getElementById('timer').textContent = 
        `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    
    // Change color when time is running out
    const timerElement = document.getElementById('timer');
    if (timeRemaining <= 60) {
        timerElement.classList.add('text-red-600', 'dark:text-red-400');
        timerElement.classList.remove('text-indigo-600', 'dark:text-indigo-400');
    } else if (timeRemaining <= 300) {
        timerElement.classList.add('text-orange-600', 'dark:text-orange-400');
        timerElement.classList.remove('text-indigo-600', 'dark:text-indigo-400');
    }
}

function updateTimeBar() {
    const percentage = (timeRemaining / timeLimit) * 100;
    const timeBar = document.getElementById('timeBar');
    timeBar.style.width = percentage + '%';
    
    if (timeRemaining <= 60) {
        timeBar.classList.add('bg-red-600', 'dark:bg-red-500');
        timeBar.classList.remove('bg-indigo-600', 'dark:bg-indigo-500');
    } else if (timeRemaining <= 300) {
        timeBar.classList.add('bg-orange-600', 'dark:bg-orange-500');
        timeBar.classList.remove('bg-indigo-600', 'dark:bg-indigo-500');
    }
}

function showQuestion(questionNumber) {
    document.querySelectorAll('.question-card').forEach(card => {
        card.classList.add('hidden');
    });
    
    document.querySelector(`[data-question="${questionNumber}"]`).classList.remove('hidden');
    document.getElementById('currentQuestion').textContent = questionNumber;
    currentQuestion = questionNumber;
    
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function nextQuestion() {
    if (currentQuestion < totalQuestions) {
        showQuestion(currentQuestion + 1);
    }
}

function previousQuestion() {
    if (currentQuestion > 1) {
        showQuestion(currentQuestion - 1);
    }
}

function submitQuiz() {
    const form = document.getElementById('quizForm');
    const formData = new FormData(form);
    const answeredQuestions = formData.getAll('answers').filter(a => a).length;
    
    if (answeredQuestions < totalQuestions) {
        if (!confirm(`You have only answered ${answeredQuestions} out of ${totalQuestions} questions. Submit anyway?`)) {
            return;
        }
    }
    
    if (confirm('Are you sure you want to submit your quiz? You cannot change your answers after submission.')) {
        clearInterval(timerInterval);
        form.submit();
    }
}
</script>
@endpush
@endsection

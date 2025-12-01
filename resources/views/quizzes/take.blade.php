@extends('layouts.app')

@section('title', 'Taking Quiz: ' . $quiz->title)

@section('content')
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
    <!-- Timer Bar -->
    <div class="sticky top-0 z-10 mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="text-sm font-medium text-gray-700 dark:text-gray-300">Time Remaining:</div>
                <div id="timer" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $quiz->duration_minutes }}:00</div>
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

                    <div class="space-y-3">
                        @foreach($question->options as $option)
                            <label class="flex items-start p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <input 
                                    type="radio" 
                                    name="answers[{{ $question->id }}]" 
                                    value="{{ $option->id }}"
                                    class="mt-0.5 h-4 w-4 text-indigo-600 focus:ring-indigo-600 dark:bg-gray-700 dark:border-gray-600"
                                    required
                                >
                                <span class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                                    {{ $option->option_text }}
                                </span>
                            </label>
                        @endforeach
                    </div>

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

<!-- Time's Up Modal -->
<div id="timesUpModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 dark:bg-red-900/20 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
                            Time's Up!
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Your quiz time has expired. Your answers will be submitted automatically.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="document.getElementById('quizForm').submit()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Submit Now
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Submit Quiz Modal -->
<div id="submitQuizModal" class="hidden fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="hideSubmitQuizModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 dark:bg-green-900/20 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                            Submit Quiz?
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 dark:text-gray-400" id="submitModalMessage">
                                Are you sure you want to submit your quiz? You cannot change your answers after submission.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="confirmSubmit()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Submit Quiz
                </button>
                <button type="button" onclick="hideSubmitQuizModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
let currentQuestion = 1;
let totalQuestions = {{ $quiz->questions->count() }};
let timeLimit = {{ $quiz->duration_minutes * 60 }}; // Convert to seconds
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
            document.getElementById('timesUpModal').classList.remove('hidden');
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
    const answeredQuestions = formData.getAll('answers[' + currentQuestion + ']').length;
    
    // Count total answered questions
    let totalAnswered = 0;
    for (let i = 1; i <= totalQuestions; i++) {
        const answer = form.querySelector(`input[name="answers[${i}]"]:checked`);
        if (answer) totalAnswered++;
    }
    
    if (totalAnswered < totalQuestions) {
        document.getElementById('submitModalMessage').textContent = 
            `You have only answered ${totalAnswered} out of ${totalQuestions} questions. Are you sure you want to submit anyway? You cannot change your answers after submission.`;
    } else {
        document.getElementById('submitModalMessage').textContent = 
            'Are you sure you want to submit your quiz? You cannot change your answers after submission.';
    }
    
    document.getElementById('submitQuizModal').classList.remove('hidden');
}

function hideSubmitQuizModal() {
    document.getElementById('submitQuizModal').classList.add('hidden');
}

function confirmSubmit() {
    clearInterval(timerInterval);
    document.getElementById('quizForm').submit();
}
</script>
@endpush
@endsection

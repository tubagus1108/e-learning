@extends('layouts.app')

@section('title', $subject->name)

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <!-- Subject Header -->
    <div class="mb-8 overflow-hidden rounded-lg bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg">
        <div class="px-6 py-8 sm:p-10">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">{{ $subject->name }}</h1>
                    <p class="mt-2 text-lg text-indigo-100">{{ $subject->code }}</p>
                    <div class="mt-4 flex flex-wrap gap-4 text-sm text-indigo-100">
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            {{ $subject->teacher->user->name ?? 'No Teacher' }}
                        </div>
                        <div class="flex items-center">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $subject->schedule_day ?? 'Not scheduled' }} • {{ $subject->schedule_time ?? 'N/A' }}
                        </div>
                    </div>
                </div>
                <div class="mt-6 sm:mt-0">
                    <a href="{{ route('subjects.index') }}" class="inline-flex items-center rounded-md bg-white/20 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-white/30">
                        ← Back to Subjects
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8">
            <button onclick="showTab('lessons')" id="tab-lessons" class="tab-button border-b-2 border-indigo-500 py-4 px-1 text-sm font-medium text-indigo-600 dark:text-indigo-400">
                Lessons
            </button>
            @if(auth()->user()->role === 'student')
                <button onclick="showTab('assignments')" id="tab-assignments" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    Assignments
                </button>
                <button onclick="showTab('quizzes')" id="tab-quizzes" class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                    Quizzes
                </button>
            @endif
        </nav>
    </div>

    <!-- Lessons Tab -->
    <div id="content-lessons" class="tab-content">
        <div class="grid grid-cols-1 gap-4">
            @forelse($subject->lessons ?? [] as $lesson)
                <a href="{{ route('lessons.show', $lesson->id) }}" class="group bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($lesson->content_type === 'video')
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-red-100 dark:bg-red-900/20">
                                            <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.91 11.672a.375.375 0 010 .656l-5.603 3.113a.375.375 0 01-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112z" />
                                            </svg>
                                        </div>
                                    @elseif($lesson->content_type === 'document')
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100 dark:bg-blue-900/20">
                                            <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                            </svg>
                                        </div>
                                    @else
                                        <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                                            <svg class="h-6 w-6 text-gray-600 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                        {{ $lesson->title }}
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                        {{ Str::limit($lesson->description, 100) }}
                                    </p>
                                    <div class="mt-2 flex items-center text-xs text-gray-500 dark:text-gray-400">
                                        <span class="capitalize">{{ $lesson->content_type }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $lesson->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ml-4">
                            <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No lessons yet</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Lessons will appear here when added.</p>
                </div>
            @endforelse
        </div>
    </div>

    @if(auth()->user()->role === 'student')
        <!-- Assignments Tab -->
        <div id="content-assignments" class="tab-content hidden">
            <div class="grid grid-cols-1 gap-4">
                @forelse($subject->assignments ?? [] as $assignment)
                    <a href="{{ route('assignments.show', $assignment->id) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $assignment->title }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($assignment->description, 150) }}</p>
                                <div class="mt-3 flex items-center gap-4 text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Due: {{ $assignment->due_date->format('M d, Y') }}</span>
                                    @if($assignment->submission)
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                            Submitted
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $assignment->due_date->isPast() ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' }}">
                                            {{ $assignment->due_date->isPast() ? 'Overdue' : 'Pending' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-12">
                        <p class="text-sm text-gray-500 dark:text-gray-400">No assignments available</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quizzes Tab -->
        <div id="content-quizzes" class="tab-content hidden">
            <div class="grid grid-cols-1 gap-4">
                @forelse($subject->quizzes ?? [] as $quiz)
                    <a href="{{ route('quizzes.show', $quiz->id) }}" class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $quiz->title }}</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ Str::limit($quiz->description, 150) }}</p>
                                <div class="mt-3 flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                                    <span>{{ $quiz->questions_count ?? 0 }} questions</span>
                                    <span>{{ $quiz->time_limit }} minutes</span>
                                    @if($quiz->attempts_count > 0)
                                        <span class="text-green-600 dark:text-green-400">Completed</span>
                                    @endif
                                </div>
                            </div>
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-12">
                        <p class="text-sm text-gray-500 dark:text-gray-400">No quizzes available</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
function showTab(tab) {
    // Hide all tabs
    document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
    document.querySelectorAll('.tab-button').forEach(el => {
        el.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
        el.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });
    
    // Show selected tab
    document.getElementById('content-' + tab).classList.remove('hidden');
    document.getElementById('tab-' + tab).classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    document.getElementById('tab-' + tab).classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
}
</script>
@endpush
@endsection

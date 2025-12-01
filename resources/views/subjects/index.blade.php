@extends('layouts.app')

@section('title', 'Subjects')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Subjects</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ auth()->user()->role === 'teacher' ? 'Subjects you are teaching' : 'Subjects you are enrolled in' }}
            </p>
        </div>
    </div>

    <!-- Subjects Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($subjects ?? [] as $subject)
            <a href="{{ route('subjects.show', $subject->id) }}" class="group relative bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-lg transition-shadow overflow-hidden">
                <!-- Subject Header -->
                <div class="h-32 bg-gradient-to-br from-indigo-500 to-purple-600 p-6">
                    <h3 class="text-xl font-bold text-white">{{ $subject->name }}</h3>
                    <p class="mt-1 text-sm text-indigo-100">{{ $subject->code }}</p>
                </div>

                <!-- Subject Info -->
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                            <span>{{ $subject->teacher->user->name ?? 'No Teacher' }}</span>
                        </div>

                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>{{ $subject->schedule_day ?? 'Not scheduled' }} • {{ $subject->schedule_time ?? 'N/A' }}</span>
                        </div>

                        <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <span>{{ $subject->lessons_count ?? 0 }} lessons</span>
                        </div>

                        @if(auth()->user()->role === 'student')
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                </svg>
                                <span>{{ $subject->assignments_count ?? 0 }} assignments</span>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-indigo-600 dark:text-indigo-400 font-medium group-hover:text-indigo-500">
                                View Details →
                            </span>
                            @if(auth()->user()->role === 'student' && isset($subject->progress))
                                <span class="text-gray-600 dark:text-gray-400">{{ $subject->progress }}% complete</span>
                            @endif
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-3 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No subjects found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ auth()->user()->role === 'teacher' ? 'You are not assigned to any subjects yet.' : 'You are not enrolled in any subjects yet.' }}
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection

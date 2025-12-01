@extends('layouts.app')

@section('title', 'My Children')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Children</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Monitor your children's academic progress and attendance</p>
    </div>

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        @forelse($children as $child)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
                <!-- Child Header -->
                <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700 bg-gradient-to-r from-indigo-50 to-purple-50 dark:from-indigo-900/20 dark:to-purple-900/20">
                    <div class="flex items-center">
                        <div class="h-16 w-16 rounded-full bg-indigo-600 dark:bg-indigo-500 flex items-center justify-center text-2xl font-bold text-white">
                            {{ substr($child->user->name, 0, 2) }}
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $child->user->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $child->student_id }} • {{ $child->classRoom->name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Academic Stats -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Academic Performance</h4>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                                {{ number_format($child->average_grade ?? 0, 1) }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Average Grade</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600 dark:text-green-400">
                                {{ $child->attendance_rate ?? 0 }}%
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Attendance</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                {{ $child->subjects_count ?? 0 }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Subjects</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Grades -->
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Recent Grades</h4>
                    @if($child->recent_grades && $child->recent_grades->count() > 0)
                        <div class="space-y-2">
                            @foreach($child->recent_grades->take(3) as $grade)
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">
                                        {{ $grade->gradable_type === 'App\\Models\\Submission' ? $grade->gradable->assignment->subject->name : $grade->gradable->quiz->subject->name }}
                                    </span>
                                    <span class="font-semibold {{ $grade->score >= 75 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                        {{ $grade->score }}/100
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No grades yet</p>
                    @endif
                </div>

                <!-- Attendance Summary -->
                <div class="px-6 py-4">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Attendance (Last 7 Days)</h4>
                    @if($child->recent_attendance && $child->recent_attendance->count() > 0)
                        <div class="flex gap-1">
                            @foreach($child->recent_attendance->sortBy('date')->take(7) as $attendance)
                                <div class="flex-1 text-center">
                                    <div class="h-12 w-full rounded {{ $attendance->status === 'present' ? 'bg-green-500' : ($attendance->status === 'absent' ? 'bg-red-500' : 'bg-yellow-500') }} flex items-center justify-center">
                                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            @if($attendance->status === 'present')
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                            @elseif($attendance->status === 'absent')
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                            @else
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd" />
                                            @endif
                                        </svg>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ $attendance->date->format('D') }}</div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">No attendance records</p>
                    @endif
                </div>

                <!-- View Details Button -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
                    <a href="{{ route('parent.child.details', $child->id) }}" class="block w-full text-center rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        View Full Report
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-2 text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No children found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No student accounts are linked to your parent account.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

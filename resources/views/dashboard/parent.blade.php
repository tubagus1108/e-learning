@extends('layouts.app')

@section('title', 'Parent Dashboard')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Welcome, {{ auth()->user()->name }}!</h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Monitor your children's academic progress.</p>
    </div>

    <!-- Children List -->
    <div class="mb-8">
        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">My Children</h2>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($children ?? [] as $child)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg cursor-pointer hover:shadow-lg transition-shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-indigo-600 flex items-center justify-center text-lg font-semibold text-white">
                                    {{ substr($child->user->name, 0, 1) }}
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">{{ $child->user->name }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $child->class_room->name ?? 'No Class' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No children registered</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Contact the administrator to link your children's accounts.</p>
                </div>
            @endforelse
        </div>
    </div>

    @if(isset($selectedChild))
    <!-- Child Details -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Academic Performance -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Academic Performance</h3>
                <dl class="space-y-4">
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Average Grade</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $selectedChild->average_grade ?? 'N/A' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Attendance Rate</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $selectedChild->attendance_rate ?? '0' }}%</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Enrolled Subjects</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $selectedChild->enrolled_subjects ?? 0 }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending Assignments</dt>
                        <dd class="text-sm font-semibold text-gray-900 dark:text-white">{{ $selectedChild->pending_assignments ?? 0 }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Recent Grades -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Recent Grades</h3>
                <div class="flow-root">
                    <ul role="list" class="-my-5 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($selectedChild->recent_grades ?? [] as $grade)
                            <li class="py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                            {{ $grade->subject->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                            {{ $grade->assignment_title ?? $grade->quiz_title }}
                                        </p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold {{ $grade->score >= 80 ? 'bg-green-100 text-green-800' : ($grade->score >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ $grade->score }}%
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="py-4 text-sm text-gray-500 dark:text-gray-400 text-center">
                                No recent grades
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>

        <!-- Attendance History -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Attendance (Last 7 Days)</h3>
                <div class="space-y-3">
                    @forelse($selectedChild->recent_attendance ?? [] as $attendance)
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600 dark:text-gray-400">{{ $attendance->date->format('l, M d') }}</span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No attendance records</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Announcements -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-white mb-4">Recent Announcements</h3>
                <div class="space-y-3">
                    @forelse($announcements ?? [] as $announcement)
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3">
                            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-300">{{ $announcement->title }}</h4>
                            <p class="mt-1 text-sm text-blue-700 dark:text-blue-400">{{ Str::limit($announcement->content, 100) }}</p>
                            <p class="mt-1 text-xs text-blue-600 dark:text-blue-500">{{ $announcement->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">No announcements</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

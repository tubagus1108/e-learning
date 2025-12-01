@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Dashboard</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">Welcome back, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Quick Stats -->
        <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-indigo-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</dt>
                                <dd class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ \App\Models\User::count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-green-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Students</dt>
                                <dd class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ \App\Models\Student::count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-blue-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Subjects</dt>
                                <dd class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ \App\Models\Subject::count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 rounded-md bg-yellow-500 p-3">
                            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                            </svg>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="truncate text-sm font-medium text-gray-500 dark:text-gray-400">Total Assignments</dt>
                                <dd class="text-2xl font-semibold text-gray-900 dark:text-white">
                                    {{ \App\Models\Assignment::count() }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Quick Actions</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <a href="/admin" class="flex items-center rounded-lg bg-white dark:bg-gray-800 p-6 shadow hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 rounded-md bg-indigo-100 dark:bg-indigo-900 p-3">
                        <svg class="h-6 w-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Admin Panel</h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Manage system settings</p>
                    </div>
                </a>

                <a href="/admin/students" class="flex items-center rounded-lg bg-white dark:bg-gray-800 p-6 shadow hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 rounded-md bg-green-100 dark:bg-green-900 p-3">
                        <svg class="h-6 w-6 text-green-600 dark:text-green-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Manage Students</h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">View and edit students</p>
                    </div>
                </a>

                <a href="/admin/subjects" class="flex items-center rounded-lg bg-white dark:bg-gray-800 p-6 shadow hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 rounded-md bg-blue-100 dark:bg-blue-900 p-3">
                        <svg class="h-6 w-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Manage Subjects</h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">View and edit subjects</p>
                    </div>
                </a>

                <a href="/admin/announcements" class="flex items-center rounded-lg bg-white dark:bg-gray-800 p-6 shadow hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 rounded-md bg-yellow-100 dark:bg-yellow-900 p-3">
                        <svg class="h-6 w-6 text-yellow-600 dark:text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 110-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 01-1.44-4.282m3.102.069a18.03 18.03 0 01-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 018.835 2.535M10.34 6.66a23.847 23.847 0 008.835-2.535m0 0A23.74 23.74 0 0018.795 3m.38 1.125a23.91 23.91 0 011.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 001.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 010 3.46" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Announcements</h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Create announcements</p>
                    </div>
                </a>

                <a href="/admin/grades" class="flex items-center rounded-lg bg-white dark:bg-gray-800 p-6 shadow hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 rounded-md bg-purple-100 dark:bg-purple-900 p-3">
                        <svg class="h-6 w-6 text-purple-600 dark:text-purple-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">View Grades</h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Monitor student grades</p>
                    </div>
                </a>

                <a href="/admin/attendances" class="flex items-center rounded-lg bg-white dark:bg-gray-800 p-6 shadow hover:shadow-md transition-shadow">
                    <div class="flex-shrink-0 rounded-md bg-red-100 dark:bg-red-900 p-3">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Attendance Records</h3>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">View attendance data</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div>
            <h2 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Recent Activity</h2>
            <div class="overflow-hidden rounded-lg bg-white dark:bg-gray-800 shadow">
                <div class="p-6">
                    <div class="flow-root">
                        <ul role="list" class="-mb-8">
                            @php
                                $recentUsers = \App\Models\User::latest()->take(5)->get();
                            @endphp
                            @foreach($recentUsers as $index => $user)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute left-4 top-4 -ml-px h-full w-0.5 bg-gray-200 dark:bg-gray-700" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-500 text-white text-sm font-medium">
                                                    {{ substr($user->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <div class="flex min-w-0 flex-1 justify-between space-x-4 pt-1.5">
                                                <div>
                                                    <p class="text-sm text-gray-900 dark:text-white">
                                                        New <span class="font-medium">{{ $user->role }}</span> registered: 
                                                        <span class="font-medium">{{ $user->name }}</span>
                                                    </p>
                                                </div>
                                                <div class="whitespace-nowrap text-right text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $user->created_at->diffForHumans() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 justify-between">
            <div class="flex">
                <!-- Logo -->
                <div class="flex shrink-0 items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 dark:text-white">
                        {{ config('app.name', 'E-Learning') }}
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 {{ request()->routeIs('dashboard') ? 'border-indigo-400 text-gray-900 dark:border-indigo-600 dark:text-white' : '' }}">
                            Beranda
                        </a>

                        @if(auth()->user()->role === 'admin')
                            <a href="/admin" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                                Panel Admin
                            </a>
                        @endif

                        @if(in_array(auth()->user()->role, ['student', 'teacher']))
                            <a href="{{ route('subjects.index') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 {{ request()->routeIs('subjects.*') ? 'border-indigo-400 text-gray-900 dark:border-indigo-600 dark:text-white' : '' }}">
                                Mata Pelajaran
                            </a>
                        @endif

                        @if(auth()->user()->role === 'student')
                            <a href="{{ route('assignments.index') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 {{ request()->routeIs('assignments.*') ? 'border-indigo-400 text-gray-900 dark:border-indigo-600 dark:text-white' : '' }}">
                                Tugas
                            </a>
                            <a href="{{ route('quizzes.index') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 {{ request()->routeIs('quizzes.*') ? 'border-indigo-400 text-gray-900 dark:border-indigo-600 dark:text-white' : '' }}">
                                Kuis
                            </a>
                            <a href="{{ route('grades.index') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 {{ request()->routeIs('grades.*') ? 'border-indigo-400 text-gray-900 dark:border-indigo-600 dark:text-white' : '' }}">
                                Nilai
                            </a>
                        @endif

                        @if(auth()->user()->role === 'teacher')
                            <a href="{{ route('attendance.index') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 {{ request()->routeIs('attendance.*') ? 'border-indigo-400 text-gray-900 dark:border-indigo-600 dark:text-white' : '' }}">
                                Kehadiran
                            </a>
                        @endif

                        @if(auth()->user()->role === 'parent')
                            <a href="{{ route('parent.children') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 {{ request()->routeIs('parent.*') ? 'border-indigo-400 text-gray-900 dark:border-indigo-600 dark:text-white' : '' }}">
                                Anak Saya
                            </a>
                        @endif

                        <a href="{{ route('announcements.index') }}" class="inline-flex items-center border-b-2 border-transparent px-1 pt-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300 {{ request()->routeIs('announcements.*') ? 'border-indigo-400 text-gray-900 dark:border-indigo-600 dark:text-white' : '' }}">
                            Pengumuman
                        </a>
                    @endauth
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:ml-6 sm:flex sm:items-center">
                @auth
                    <!-- Notifications -->
                    <button type="button" class="relative rounded-full bg-white dark:bg-gray-800 p-1 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                        <span class="sr-only">Lihat notifikasi</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                        </svg>
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-400 ring-2 ring-white dark:ring-gray-800"></span>
                    </button>

                    <!-- Profile dropdown -->
                    <div class="relative ml-3">
                        <div class="flex items-center">
                            <button type="button" class="flex rounded-full bg-white dark:bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                                <span class="sr-only">Buka menu pengguna</span>
                                <div class="h-8 w-8 rounded-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center text-sm font-medium text-gray-700 dark:text-gray-200">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </button>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst(auth()->user()->role) }}</div>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" class="ml-3">
                        @csrf
                        <button type="submit" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-900 dark:text-white">Masuk</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">Daftar</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

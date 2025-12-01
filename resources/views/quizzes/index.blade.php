@extends('layouts.app')

@section('title', 'Kuis')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Kuis Saya</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Uji pengetahuan Anda dengan kuis</p>
        </div>
    </div>

    <!-- Quizzes List -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($quizzes ?? [] as $quiz)
            @php
                $hasAttempt = $quiz->attempt !== null;
                $isPassed = $hasAttempt && $quiz->attempt->score >= 70;
            @endphp
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow overflow-hidden">
                <!-- Quiz Header -->
                <div class="h-24 bg-gradient-to-br {{ $hasAttempt ? ($isPassed ? 'from-green-500 to-emerald-600' : 'from-gray-500 to-gray-600') : 'from-purple-500 to-pink-600' }} p-6 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-white">{{ $quiz->title }}</h3>
                        @if($hasAttempt)
                            <p class="mt-1 text-sm text-white/90">Nilai: {{ $quiz->attempt->score }}/100</p>
                        @endif
                    </div>
                    @if($hasAttempt)
                        <svg class="h-10 w-10 text-white/80" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                    @endif
                </div>

                <!-- Quiz Content -->
                <div class="p-6">
                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $quiz->description }}</p>

                    <div class="mt-4 space-y-2">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            {{ $quiz->subject->name }}
                        </div>

                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                            </svg>
                            {{ $quiz->questions_count ?? 0 }} soal
                        </div>

                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $quiz->duration_minutes }} menit
                        </div>
                    </div>

                    <div class="mt-6">
                        @if($hasAttempt)
                            <a href="{{ route('quizzes.result', $quiz->id) }}" class="block w-full text-center rounded-md {{ $isPassed ? 'bg-green-600 hover:bg-green-500' : 'bg-gray-600 hover:bg-gray-500' }} px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm">
                                Lihat Hasil
                            </a>
                        @else
                            <a href="{{ route('quizzes.show', $quiz->id) }}" class="block w-full text-center rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                Mulai Kuis
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">Tidak ada kuis tersedia</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Periksa kembali nanti untuk kuis baru.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', $quiz->title)

@section('content')
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
    <!-- Quiz Header -->
    <div class="mb-8 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-5 bg-gradient-to-br from-purple-500 to-pink-600">
            <h1 class="text-3xl font-bold text-white">{{ $quiz->title }}</h1>
            <p class="mt-2 text-lg text-purple-100">{{ $quiz->subject->name }}</p>
        </div>
        <div class="px-6 py-5">
            <p class="text-gray-600 dark:text-gray-400">{{ $quiz->description }}</p>

            <div class="mt-6 grid grid-cols-3 gap-4">
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $quiz->questions->count() }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Soal</div>
                </div>
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $quiz->duration_minutes }}</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Menit</div>
                </div>
                <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <div class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">70%</div>
                    <div class="text-sm text-gray-600 dark:text-gray-400">Nilai Lulus</div>
                </div>
            </div>

            <div class="mt-6 rounded-md bg-blue-50 dark:bg-blue-900/20 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">Petunjuk</h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Anda memiliki waktu {{ $quiz->duration_minutes }} menit untuk menyelesaikan kuis ini</li>
                                <li>Kuis akan otomatis terkirim saat waktu habis</li>
                                <li>Anda hanya bisa mengerjakan kuis ini satu kali</li>
                                <li>Semua soal harus dijawab</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <a href="{{ route('quizzes.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    ← Kembali ke Daftar Kuis
                </a>
                <a href="{{ route('quizzes.take', $quiz->id) }}" class="rounded-md bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Mulai Kuis Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

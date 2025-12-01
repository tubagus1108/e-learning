@extends('layouts.app')

@section('title', $lesson->title)

@section('content')
<div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('subjects.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white">
                    Subjects
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <a href="{{ route('subjects.show', $lesson->subject_id) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white md:ml-2">
                        {{ $lesson->subject->name }}
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2">{{ $lesson->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Lesson Header -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $lesson->title }}</h1>
        @if($lesson->description)
            <p class="mt-2 text-gray-600 dark:text-gray-400">{{ $lesson->description }}</p>
        @endif
        <div class="mt-4 flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
            <span class="inline-flex items-center">
                <svg class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                {{ $lesson->created_at->format('M d, Y') }}
            </span>
            <span class="inline-flex items-center capitalize">
                <svg class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0112 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                </svg>
                {{ $lesson->content_type }}
            </span>
        </div>
    </div>

    <!-- Lesson Content -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        @if($lesson->content_type === 'video')
            <!-- Video Content -->
            <div class="aspect-video bg-black">
                @if($lesson->video_url)
                    @if(str_contains($lesson->video_url, 'youtube.com') || str_contains($lesson->video_url, 'youtu.be'))
                        <iframe 
                            class="w-full h-full" 
                            src="https://www.youtube.com/embed/{{ $lesson->youtube_id }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    @else
                        <video class="w-full h-full" controls>
                            <source src="{{ $lesson->video_url }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                @else
                    <div class="flex items-center justify-center h-full text-white">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-2 text-sm text-gray-400">No video available</p>
                        </div>
                    </div>
                @endif
            </div>

        @elseif($lesson->content_type === 'document')
            <!-- Document Content -->
            <div class="p-6">
                @if($lesson->file_url)
                    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="h-10 w-10 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Lesson Document</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ pathinfo($lesson->file_url, PATHINFO_EXTENSION) }} file</p>
                                </div>
                            </div>
                            <a href="{{ $lesson->file_url }}" download class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>

                    <!-- PDF Viewer -->
                    @if(str_ends_with($lesson->file_url, '.pdf'))
                        <div class="mt-6">
                            <iframe src="{{ $lesson->file_url }}" class="w-full h-[600px] rounded-lg border border-gray-200 dark:border-gray-700"></iframe>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">No document available</p>
                    </div>
                @endif
            </div>

        @else
            <!-- Text Content -->
            <div class="p-6 prose dark:prose-invert max-w-none">
                {!! nl2br(e($lesson->content_text)) !!}
            </div>
        @endif
    </div>

    <!-- Lesson Navigation -->
    @if($previousLesson || $nextLesson)
        <div class="flex items-center justify-between bg-white dark:bg-gray-800 rounded-lg shadow p-4">
            <div>
                @if($previousLesson)
                    <a href="{{ route('lessons.show', $previousLesson->id) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        <svg class="mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                        Previous: {{ Str::limit($previousLesson->title, 30) }}
                    </a>
                @endif
            </div>
            <div>
                @if($nextLesson)
                    <a href="{{ route('lessons.show', $nextLesson->id) }}" class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                        Next: {{ Str::limit($nextLesson->title, 30) }}
                        <svg class="ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

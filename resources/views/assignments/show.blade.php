@extends('layouts.app')

@section('title', $assignment->title)

@section('content')
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb -->
    <nav class="mb-6 flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('assignments.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-white">
                    Assignments
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="h-6 w-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 dark:text-gray-400 md:ml-2">{{ $assignment->title }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Assignment Details -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $assignment->title }}</h1>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $assignment->subject->name }}</p>
                </div>
                @php
                    $isSubmitted = isset($assignment->submission);
                    $isOverdue = $assignment->due_date->isPast() && !$isSubmitted;
                @endphp
                <span class="inline-flex items-center rounded-full px-3 py-1 text-sm font-medium {{ $isSubmitted ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : ($isOverdue ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400') }}">
                    {{ $isSubmitted ? 'Submitted' : ($isOverdue ? 'Overdue' : 'Pending') }}
                </span>
            </div>
        </div>

        <div class="px-6 py-5 space-y-4">
            <div>
                <h3 class="text-sm font-medium text-gray-900 dark:text-white">Description</h3>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $assignment->description }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Due Date</h3>
                    <p class="mt-1 text-sm {{ $isOverdue ? 'text-red-600 dark:text-red-400 font-medium' : 'text-gray-600 dark:text-gray-400' }}">
                        {{ $assignment->due_date->format('l, F d, Y \a\t h:i A') }}
                        @if(!$isSubmitted)
                            <span class="block text-xs mt-0.5">{{ $assignment->due_date->diffForHumans() }}</span>
                        @endif
                    </p>
                </div>

                @if($assignment->file_url)
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Attachment</h3>
                        <a href="{{ $assignment->file_url }}" download class="mt-1 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                            <svg class="mr-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            Download Assignment File
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($isSubmitted)
        <!-- Submission View -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Your Submission</h2>
            </div>
            <div class="px-6 py-5 space-y-4">
                <div>
                    <h3 class="text-sm font-medium text-gray-900 dark:text-white">Submitted At</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $assignment->submission->submitted_at->format('F d, Y \a\t h:i A') }}</p>
                </div>

                @if($assignment->submission->content)
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Answer</h3>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap">{{ $assignment->submission->content }}</p>
                    </div>
                @endif

                @if($assignment->submission->file_url)
                    <div>
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Submitted File</h3>
                        <a href="{{ $assignment->submission->file_url }}" download class="mt-2 inline-flex items-center rounded-md bg-white dark:bg-gray-700 px-3 py-2 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <svg class="mr-2 h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            Download Submission File
                        </a>
                    </div>
                @endif

                @if($assignment->grade)
                    <div class="rounded-md bg-indigo-50 dark:bg-indigo-900/20 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3 flex-1">
                                <h3 class="text-sm font-medium text-indigo-800 dark:text-indigo-200">Graded</h3>
                                <div class="mt-2 text-sm text-indigo-700 dark:text-indigo-300">
                                    <p class="font-semibold text-lg">Score: {{ $assignment->grade->score }}/100</p>
                                    @if($assignment->grade->feedback)
                                        <p class="mt-2"><strong>Feedback:</strong> {{ $assignment->grade->feedback }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="rounded-md bg-yellow-50 dark:bg-yellow-900/20 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">Pending Review</h3>
                                <p class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">Your submission is being reviewed by the teacher.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <!-- Submission Form -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Submit Your Work</h2>
            </div>
            <form action="{{ route('assignments.submit', $assignment->id) }}" method="POST" enctype="multipart/form-data" class="px-6 py-5 space-y-6">
                @csrf

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-900 dark:text-white">
                        Answer <span class="text-gray-500 dark:text-gray-400">(Optional)</span>
                    </label>
                    <textarea 
                        id="content" 
                        name="content" 
                        rows="6" 
                        class="mt-2 block w-full rounded-md border-0 py-1.5 px-3 text-gray-900 dark:text-white bg-white dark:bg-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                        placeholder="Type your answer here..."
                    >{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="file" class="block text-sm font-medium text-gray-900 dark:text-white">
                        Upload File <span class="text-gray-500 dark:text-gray-400">(Optional)</span>
                    </label>
                    <div class="mt-2 flex items-center gap-x-3">
                        <input 
                            type="file" 
                            id="file" 
                            name="file" 
                            class="block w-full text-sm text-gray-900 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/20 dark:file:text-indigo-400"
                        />
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">PDF, DOC, DOCX, or ZIP files up to 10MB</p>
                    @error('file')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                @if($isOverdue)
                    <div class="rounded-md bg-red-50 dark:bg-red-900/20 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800 dark:text-red-200">This assignment is overdue</h3>
                                <p class="mt-2 text-sm text-red-700 dark:text-red-300">You can still submit, but it will be marked as late submission.</p>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="flex items-center justify-end gap-x-3">
                    <a href="{{ route('assignments.index') }}" class="rounded-md bg-white dark:bg-gray-700 px-3.5 py-2.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Submit Assignment
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection

@extends('layouts.app')

@section('title', 'Create Announcement')

@section('content')
<div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create Announcement</h1>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Share important information with students and parents</p>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <form action="{{ route('announcements.store') }}" method="POST" class="p-6 space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-900 dark:text-white">Title *</label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    required 
                    value="{{ old('title') }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Enter announcement title"
                >
                @error('title')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-medium text-gray-900 dark:text-white">Content *</label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="6" 
                    required 
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    placeholder="Enter announcement content"
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div>
                    <label for="priority" class="block text-sm font-medium text-gray-900 dark:text-white">Priority *</label>
                    <select 
                        id="priority" 
                        name="priority" 
                        required 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High</option>
                    </select>
                    @error('priority')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="target_role" class="block text-sm font-medium text-gray-900 dark:text-white">Target Audience</label>
                    <select 
                        id="target_role" 
                        name="target_role" 
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">All Users</option>
                        <option value="student" {{ old('target_role') === 'student' ? 'selected' : '' }}>Students</option>
                        <option value="teacher" {{ old('target_role') === 'teacher' ? 'selected' : '' }}>Teachers</option>
                        <option value="parent" {{ old('target_role') === 'parent' ? 'selected' : '' }}>Parents</option>
                    </select>
                    @error('target_role')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-x-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <a href="{{ route('announcements.index') }}" class="rounded-md bg-white dark:bg-gray-700 px-3.5 py-2.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                    Cancel
                </a>
                <button type="submit" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Publish Announcement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

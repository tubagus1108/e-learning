@extends('layouts.app')

@section('title', 'Assignments')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Assignments</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">View and submit your assignments</p>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-6 border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8">
            <button onclick="filterAssignments('all')" id="filter-all" class="filter-tab border-b-2 border-indigo-500 py-4 px-1 text-sm font-medium text-indigo-600 dark:text-indigo-400">
                All ({{ $assignments->count() }})
            </button>
            <button onclick="filterAssignments('pending')" id="filter-pending" class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                Pending ({{ $assignments->where('submission', null)->where('due_date', '>=', now())->count() }})
            </button>
            <button onclick="filterAssignments('submitted')" id="filter-submitted" class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                Submitted ({{ $assignments->whereNotNull('submission')->count() }})
            </button>
            <button onclick="filterAssignments('overdue')" id="filter-overdue" class="filter-tab border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                Overdue ({{ $assignments->where('submission', null)->where('due_date', '<', now())->count() }})
            </button>
        </nav>
    </div>

    <!-- Assignments List -->
    <div class="space-y-4">
        @forelse($assignments ?? [] as $assignment)
            @php
                $isSubmitted = $assignment->submissions->isNotEmpty();
                $isOverdue = $assignment->due_date->isPast() && !$isSubmitted;
                $isPending = !$isSubmitted && !$isOverdue;
                $daysUntilDue = now()->diffInDays($assignment->due_date, false);
            @endphp
            <div class="assignment-card bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow" 
                 data-status="{{ $isSubmitted ? 'submitted' : ($isOverdue ? 'overdue' : 'pending') }}">
                <div class="p-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $assignment->title }}</h3>
                                @if($isSubmitted)
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                        <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                                        </svg>
                                        Submitted
                                    </span>
                                @elseif($isOverdue)
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                        Overdue
                                    </span>
                                @elseif($daysUntilDue <= 2)
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400">
                                        Due Soon
                                    </span>
                                @endif
                            </div>

                            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($assignment->description, 200) }}</p>

                            <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-500 dark:text-gray-400">
                                <div class="flex items-center">
                                    <svg class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    {{ $assignment->subject->name }}
                                </div>
                                <div class="flex items-center {{ $isOverdue ? 'text-red-600 dark:text-red-400 font-medium' : '' }}">
                                    <svg class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                    </svg>
                                    Due: {{ $assignment->due_date->format('M d, Y h:i A') }}
                                    @if(!$isSubmitted && !$isOverdue)
                                        <span class="ml-1">({{ abs($daysUntilDue) }} {{ abs($daysUntilDue) === 1 ? 'day' : 'days' }})</span>
                                    @endif
                                </div>
                                @if($isSubmitted && $assignment->grade)
                                    <div class="flex items-center text-indigo-600 dark:text-indigo-400 font-medium">
                                        <svg class="mr-1.5 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                                        </svg>
                                        Grade: {{ $assignment->grade->score }}/100
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="ml-6">
                            <a href="{{ route('assignments.show', $assignment->id) }}" class="inline-flex items-center rounded-md bg-indigo-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                                {{ $isSubmitted ? 'View Submission' : 'Submit Assignment' }}
                                <svg class="ml-1.5 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No assignments found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You don't have any assignments yet.</p>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
function filterAssignments(status) {
    const cards = document.querySelectorAll('.assignment-card');
    const tabs = document.querySelectorAll('.filter-tab');
    
    // Update tab styles
    tabs.forEach(tab => {
        tab.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
        tab.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    });
    
    document.getElementById('filter-' + status).classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
    document.getElementById('filter-' + status).classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
    
    // Filter cards
    cards.forEach(card => {
        if (status === 'all' || card.dataset.status === status) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}
</script>
@endpush
@endsection

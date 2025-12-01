@extends('layouts.app')

@section('title', 'Attendance Management')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Attendance Management</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Mark and track student attendance for your classes</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <button onclick="showMarkAttendanceModal()" class="inline-flex items-center rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                Mark Attendance
            </button>
        </div>
    </div>

    <!-- Filter -->
    <div class="mb-6 bg-white dark:bg-gray-800 rounded-lg shadow p-4">
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div>
                <label for="filterSubject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
                <select id="filterSubject" onchange="filterAttendance()" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Subjects</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="filterDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                <input type="date" id="filterDate" onchange="filterAttendance()" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" value="{{ now()->format('Y-m-d') }}">
            </div>
            <div>
                <label for="filterClass" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class</label>
                <select id="filterClass" onchange="filterAttendance()" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">All Classes</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <!-- Attendance Records -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Attendance Records</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Student</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Class</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Subject</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Date</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Status</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">Notes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800" id="attendanceTableBody">
                    @forelse($attendances as $attendance)
                        <tr data-subject="{{ $attendance->subject_id }}" data-class="{{ $attendance->student->class_room_id }}" data-date="{{ $attendance->date->format('Y-m-d') }}">
                            <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-sm font-medium text-gray-600 dark:text-gray-300">
                                        {{ substr($attendance->student->user->name, 0, 2) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $attendance->student->user->name }}</div>
                                        <div class="text-gray-500 dark:text-gray-400">{{ $attendance->student->student_id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $attendance->student->classRoom->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $attendance->subject->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $attendance->date->format('M d, Y') }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $attendance->status === 'present' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : ($attendance->status === 'absent' ? 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400' : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400') }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-4 text-sm text-gray-500 dark:text-gray-400">{{ $attendance->notes ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No attendance records</h3>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start marking attendance for your classes.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Mark Attendance Modal -->
<div id="markAttendanceModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="flex min-h-screen items-center justify-center p-4">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mark Attendance</h3>
            </div>
            
            <form action="{{ route('attendance.store') }}" method="POST" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-6">
                    <div>
                        <label for="modalSubject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject *</label>
                        <select id="modalSubject" name="subject_id" required onchange="loadStudents()" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="modalDate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date *</label>
                        <input type="date" id="modalDate" name="date" required value="{{ now()->format('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>
                </div>

                <div id="studentsContainer" class="mb-6">
                    <p class="text-sm text-gray-500 dark:text-gray-400">Select a subject to load students</p>
                </div>

                <div class="flex items-center justify-end gap-x-3">
                    <button type="button" onclick="hideMarkAttendanceModal()" class="rounded-md bg-white dark:bg-gray-700 px-3.5 py-2.5 text-sm font-semibold text-gray-900 dark:text-white shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600">
                        Cancel
                    </button>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        Save Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showMarkAttendanceModal() {
    document.getElementById('markAttendanceModal').classList.remove('hidden');
}

function hideMarkAttendanceModal() {
    document.getElementById('markAttendanceModal').classList.add('hidden');
}

function filterAttendance() {
    const subjectFilter = document.getElementById('filterSubject').value;
    const dateFilter = document.getElementById('filterDate').value;
    const classFilter = document.getElementById('filterClass').value;
    const rows = document.querySelectorAll('#attendanceTableBody tr[data-subject]');
    
    rows.forEach(row => {
        const matchSubject = !subjectFilter || row.dataset.subject === subjectFilter;
        const matchDate = !dateFilter || row.dataset.date === dateFilter;
        const matchClass = !classFilter || row.dataset.class === classFilter;
        
        if (matchSubject && matchDate && matchClass) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

async function loadStudents() {
    const subjectId = document.getElementById('modalSubject').value;
    const container = document.getElementById('studentsContainer');
    
    if (!subjectId) {
        container.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">Select a subject to load students</p>';
        return;
    }
    
    container.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">Loading students...</p>';
    
    try {
        const response = await fetch(`/api/subjects/${subjectId}/students`);
        const students = await response.json();
        
        if (students.length === 0) {
            container.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400">No students enrolled in this subject</p>';
            return;
        }
        
        let html = '<div class="space-y-3"><label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Students</label>';
        
        students.forEach(student => {
            html += `
                <div class="flex items-center justify-between p-3 border border-gray-200 dark:border-gray-700 rounded-lg">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-medium text-gray-600 dark:text-gray-300">
                            ${student.user.name.substring(0, 2)}
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">${student.user.name}</div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">${student.student_id}</div>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="students[${student.id}]" value="present" class="h-4 w-4 text-green-600 focus:ring-green-600" checked>
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Present</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="students[${student.id}]" value="absent" class="h-4 w-4 text-red-600 focus:ring-red-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Absent</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="students[${student.id}]" value="late" class="h-4 w-4 text-yellow-600 focus:ring-yellow-600">
                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Late</span>
                        </label>
                    </div>
                </div>
            `;
        });
        
        html += '</div>';
        container.innerHTML = html;
    } catch (error) {
        container.innerHTML = '<p class="text-sm text-red-600 dark:text-red-400">Error loading students</p>';
    }
}
</script>
@endpush
@endsection

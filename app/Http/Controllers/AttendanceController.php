<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Subject;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $subjects = Subject::query()
            ->whereHas('teacher', fn($q) => $q->where('user_id', $user->id))
            ->get();

        $classes = ClassRoom::query()
            ->whereHas('subjects.teacher', fn($q) => $q->where('user_id', $user->id))
            ->get();

        $attendances = Attendance::query()
            ->whereHas('subject.teacher', fn($q) => $q->where('user_id', $user->id))
            ->with(['student.user', 'student.classRoom', 'subject'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('attendance.index', compact('subjects', 'classes', 'attendances'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'students' => 'required|array',
            'students.*' => 'required|in:present,absent,late',
        ]);

        foreach ($validated['students'] as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $validated['subject_id'],
                    'date' => $validated['date'],
                ],
                [
                    'status' => $status,
                ]
            );
        }

        return redirect()
            ->route('attendance.index')
            ->with('success', 'Attendance marked successfully!');
    }

    public function getStudentsBySubject(Subject $subject): \Illuminate\Http\JsonResponse
    {
        $students = Student::query()
            ->whereHas('classRoom.subjects', fn($q) => $q->where('subjects.id', $subject->id))
            ->with('user')
            ->get();

        return response()->json($students);
    }
}

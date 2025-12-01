<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Grade;
use App\Models\Attendance;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function children(): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $children = Student::query()
            ->where('parent_id', $user->id)
            ->with(['user', 'classRoom'])
            ->get()
            ->map(function ($child) {
                $child->average_grade = Grade::query()
                    ->whereHasMorph('gradable', ['App\Models\Submission', 'App\Models\QuizAttempt'], function ($q) use ($child) {
                        $q->where('student_id', $child->id);
                    })
                    ->avg('score');

                $child->recent_grades = Grade::query()
                    ->whereHasMorph('gradable', ['App\Models\Submission', 'App\Models\QuizAttempt'], function ($q) use ($child) {
                        $q->where('student_id', $child->id);
                    })
                    ->with(['gradable.assignment.subject', 'gradable.quiz.subject'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

                $attendances = Attendance::query()
                    ->where('student_id', $child->id)
                    ->get();

                $child->recent_attendance = $attendances->sortByDesc('date')->take(7);
                
                $totalAttendance = $attendances->count();
                $presentCount = $attendances->where('status', 'present')->count();
                $child->attendance_rate = $totalAttendance > 0 ? round(($presentCount / $totalAttendance) * 100) : 0;

                $child->subjects_count = $child->classRoom->subjects->count();

                return $child;
            });

        return view('parent.children', compact('children'));
    }

    public function childDetails(Student $child): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if ($child->parent_id !== $user->id) {
            abort(403);
        }

        return view('parent.child-details', compact('child'));
    }
}

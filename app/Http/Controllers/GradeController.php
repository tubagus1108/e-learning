<?php

namespace App\Http\Controllers;

use App\Models\Grade;

class GradeController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        $grades = Grade::query()
            ->whereHas('gradable', function ($query) use ($user) {
                $query->where(function ($q) use ($user) {
                    $q->whereHasMorph('gradable', ['App\Models\Submission'], function ($sq) use ($user) {
                        $sq->where('student_id', $user->student->id);
                    })->orWhereHasMorph('gradable', ['App\Models\QuizAttempt'], function ($sq) use ($user) {
                        $sq->where('student_id', $user->student->id);
                    });
                });
            })
            ->with(['gradable.assignment.subject', 'gradable.quiz.subject'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate statistics
        $statistics = [
            'average' => $grades->avg('score') ?? 0,
            'highest' => $grades->max('score') ?? 0,
            'lowest' => $grades->min('score') ?? 0,
            'total' => $grades->count(),
        ];

        // Group grades by subject
        $gradesBySubject = $grades->groupBy(function ($grade) {
            if ($grade->gradable_type === 'App\Models\Submission') {
                return $grade->gradable->assignment->subject_id;
            } else {
                return $grade->gradable->quiz->subject_id;
            }
        })->map(function ($subjectGrades, $subjectId) {
            $firstGrade = $subjectGrades->first();
            $subject = $firstGrade->gradable_type === 'App\Models\Submission'
                ? $firstGrade->gradable->assignment->subject
                : $firstGrade->gradable->quiz->subject;

            return [
                'id' => $subject->id,
                'name' => $subject->name,
                'code' => $subject->code,
                'average' => $subjectGrades->avg('score'),
                'grades' => $subjectGrades,
            ];
        })->sortByDesc('average')->values();

        return view('grades.index', compact('grades', 'statistics', 'gradesBySubject'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if ($user->role === 'teacher') {
            $subjects = Subject::query()
                ->whereHas('teacher', fn($q) => $q->where('user_id', $user->id))
                ->withCount(['lessons', 'assignments'])
                ->with('teacher.user')
                ->get();
        } elseif ($user->role === 'student') {
            $subjects = Subject::query()
                ->whereHas('classRoom.students', fn($q) => $q->where('user_id', $user->id))
                ->withCount(['lessons', 'assignments'])
                ->with('teacher.user')
                ->get();
        } else {
            $subjects = collect();
        }

        return view('subjects.index', compact('subjects'));
    }

    public function show(Subject $subject): \Illuminate\View\View
    {
        $subject->load([
            'teacher.user',
            'lessons' => fn($q) => $q->orderBy('created_at'),
            'assignments' => fn($q) => $q->orderBy('due_date'),
            'quizzes' => fn($q) => $q->withCount('questions'),
        ]);

        return view('subjects.show', compact('subject'));
    }
}

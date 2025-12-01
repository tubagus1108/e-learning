<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $assignments = Assignment::query()
            ->whereHas('subject.classRoom.students', fn($q) => $q->where('user_id', $user->id))
            ->with(['subject', 'submissions' => fn($q) => $q->where('student_id', $user->student->id)->with('grade')])
            ->orderBy('due_date')
            ->get();

        return view('assignments.index', compact('assignments'));
    }

    public function show(Assignment $assignment): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $assignment->load([
            'subject',
            'submissions' => fn($q) => $q->where('student_id', $user->student->id)->with('grade'),
        ]);

        return view('assignments.show', compact('assignment'));
    }

    public function submit(Request $request, Assignment $assignment): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,zip|max:10240',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $fileUrl = null;
        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('submissions', 'public');
            $fileUrl = Storage::url($path);
        }

        Submission::create([
            'assignment_id' => $assignment->id,
            'student_id' => $user->student->id,
            'content' => $validated['content'] ?? null,
            'file_url' => $fileUrl,
            'submitted_at' => now(),
        ]);

        return redirect()
            ->route('assignments.show', $assignment->id)
            ->with('success', 'Assignment submitted successfully!');
    }
}

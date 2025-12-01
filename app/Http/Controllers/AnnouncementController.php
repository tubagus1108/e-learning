<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        $announcements = Announcement::query()
            ->where(function ($q) use ($user) {
                $q->whereNull('target_role')
                  ->orWhere('target_role', $user->role);
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('announcements.index', compact('announcements'));
    }

    public function create(): \Illuminate\View\View
    {
        return view('announcements.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'target_role' => 'nullable|in:student,teacher,parent',
        ]);

        /** @var \App\Models\User $user */
        $user = auth()->user();

        Announcement::create([
            'user_id' => $user->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'priority' => $validated['priority'],
            'target_role' => $validated['target_role'] ?? null,
        ]);

        return redirect()
            ->route('announcements.index')
            ->with('success', 'Announcement published successfully!');
    }

    public function destroy(Announcement $announcement): \Illuminate\Http\JsonResponse
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();
        
        if ($announcement->user_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $announcement->delete();

        return response()->json(['success' => true]);
    }
}

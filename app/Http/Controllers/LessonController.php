<?php

namespace App\Http\Controllers;

use App\Models\Lesson;

class LessonController extends Controller
{
    public function show(Lesson $lesson): \Illuminate\View\View
    {
        $lesson->load('subject.teacher.user');

        // Get previous and next lessons
        $previousLesson = Lesson::query()
            ->where('subject_id', $lesson->subject_id)
            ->where('id', '<', $lesson->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextLesson = Lesson::query()
            ->where('subject_id', $lesson->subject_id)
            ->where('id', '>', $lesson->id)
            ->orderBy('id')
            ->first();

        // Extract YouTube ID if it's a YouTube video
        if ($lesson->content_type === 'video' && $lesson->video_url) {
            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\?]+)/', $lesson->video_url, $matches)) {
                $lesson->youtube_id = $matches[1];
            }
        }

        return view('lessons.show', compact('lesson', 'previousLesson', 'nextLesson'));
    }
}

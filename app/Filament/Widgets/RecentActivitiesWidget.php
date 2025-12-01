<?php

namespace App\Filament\Widgets;

use App\Models\Assignment;
use App\Models\Lesson;
use App\Models\Quiz;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class RecentActivitiesWidget extends TableWidget
{
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        // Combine recent assignments, lessons, and quizzes
        $recentActivities = collect();

        // Get recent assignments
        Assignment::latest()
            ->take(5)
            ->get()
            ->each(function ($assignment) use ($recentActivities) {
                $recentActivities->push([
                    'type' => 'Assignment',
                    'title' => $assignment->title,
                    'date' => $assignment->created_at,
                    'subject' => $assignment->subject->name ?? 'N/A',
                ]);
            });

        // Get recent lessons
        Lesson::latest()
            ->take(5)
            ->get()
            ->each(function ($lesson) use ($recentActivities) {
                $recentActivities->push([
                    'type' => 'Lesson',
                    'title' => $lesson->title,
                    'date' => $lesson->created_at,
                    'subject' => $lesson->subject->name ?? 'N/A',
                ]);
            });

        // Get recent quizzes
        Quiz::latest()
            ->take(5)
            ->get()
            ->each(function ($quiz) use ($recentActivities) {
                $recentActivities->push([
                    'type' => 'Quiz',
                    'title' => $quiz->title,
                    'date' => $quiz->created_at,
                    'subject' => $quiz->subject->name ?? 'N/A',
                ]);
            });

        return $table
            ->heading('Recent Activities')
            ->query(
                Assignment::query()
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('subject.name')
                    ->label('Subject')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('title')
                    ->label('Activity')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

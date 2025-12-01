<?php

namespace App\Filament\Resources\Grades\Grades\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->label('Student')
                    ->relationship('student.user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('subject_id')
                    ->label('Subject')
                    ->relationship('subject', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('gradable_type')
                    ->label('Type')
                    ->options([
                        'App\\Models\\Submission' => 'Assignment Submission',
                        'App\\Models\\QuizAttempt' => 'Quiz Attempt',
                    ])
                    ->required(),
                TextInput::make('gradable_id')
                    ->label('Gradable ID')
                    ->numeric()
                    ->required(),
                TextInput::make('score')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100),
                Textarea::make('feedback')
                    ->rows(3)
                    ->maxLength(1000),
                DateTimePicker::make('graded_at')
                    ->default(now())
                    ->required(),
            ]);
    }
}

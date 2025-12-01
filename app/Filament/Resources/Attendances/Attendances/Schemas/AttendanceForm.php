<?php

namespace App\Filament\Resources\Attendances\Attendances\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AttendanceForm
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
                DatePicker::make('date')
                    ->required()
                    ->default(now())
                    ->native(false),
                Select::make('status')
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'late' => 'Late',
                    ])
                    ->required()
                    ->default('present'),
                Textarea::make('notes')
                    ->rows(2)
                    ->maxLength(500),
            ]);
    }
}

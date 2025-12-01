<?php

namespace App\Filament\Resources\Subjects\Subjects\Schemas;

use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Schema;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required()
                    ->maxLength(10)
                    ->unique(ignoreRecord: true),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->rows(3)
                    ->maxLength(1000),
                Select::make('teacher_id')
                    ->label('Teacher')
                    ->relationship('teacher.user', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('class_room_id')
                    ->label('Class Room')
                    ->relationship('classRoom', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('credits')
                    ->numeric()
                    ->default(3)
                    ->required()
                    ->minValue(1)
                    ->maxValue(6),
            ]);
    }
}

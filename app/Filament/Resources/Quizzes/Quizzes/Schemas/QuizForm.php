<?php

namespace App\Filament\Resources\Quizzes\Quizzes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class QuizForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('subject_id')
                    ->label('Subject')
                    ->relationship('subject', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->rows(3)
                    ->maxLength(1000),
                TextInput::make('duration')
                    ->label('Duration (minutes)')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->default(60),
                TextInput::make('passing_score')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->maxValue(100)
                    ->default(75),
                Toggle::make('is_active')
                    ->default(true),
            ]);
    }
}

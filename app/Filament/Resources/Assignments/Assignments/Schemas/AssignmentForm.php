<?php

namespace App\Filament\Resources\Assignments\Assignments\Schemas;

use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Components\Textarea;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\DateTimePicker;
use Filament\Schemas\Components\FileUpload;
use Filament\Schemas\Schema;

class AssignmentForm
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
                    ->rows(5)
                    ->maxLength(5000)
                    ->required(),
                FileUpload::make('file_path')
                    ->label('Attachment')
                    ->maxSize(10240)
                    ->directory('assignments'),
                DateTimePicker::make('due_date')
                    ->required()
                    ->native(false)
                    ->minDate(now()),
                TextInput::make('max_score')
                    ->numeric()
                    ->default(100)
                    ->required()
                    ->minValue(1)
                    ->maxValue(100),
            ]);
    }
}

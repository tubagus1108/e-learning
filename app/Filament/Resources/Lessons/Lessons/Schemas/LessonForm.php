<?php

namespace App\Filament\Resources\Lessons\Lessons\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class LessonForm
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
                Textarea::make('content')
                    ->rows(5)
                    ->maxLength(5000),
                Select::make('content_type')
                    ->options([
                        'text' => 'Text',
                        'video' => 'Video',
                        'pdf' => 'PDF',
                    ])
                    ->required()
                    ->default('text'),
                TextInput::make('video_url')
                    ->url()
                    ->maxLength(500)
                    ->visible(fn ($get) => $get('content_type') === 'video'),
                FileUpload::make('file_path')
                    ->label('PDF File')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240)
                    ->directory('lessons')
                    ->visible(fn ($get) => $get('content_type') === 'pdf'),
                TextInput::make('order')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->minValue(1),
                TextInput::make('duration')
                    ->label('Duration (minutes)')
                    ->numeric()
                    ->minValue(1),
            ]);
    }
}

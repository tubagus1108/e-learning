<?php

namespace App\Filament\Resources\Lessons\Lessons;

use App\Filament\Resources\Lessons\Lessons\Pages\CreateLesson;
use App\Filament\Resources\Lessons\Lessons\Pages\EditLesson;
use App\Filament\Resources\Lessons\Lessons\Pages\ListLessons;
use App\Filament\Resources\Lessons\Lessons\Pages\ViewLesson;
use App\Filament\Resources\Lessons\Lessons\Schemas\LessonForm;
use App\Filament\Resources\Lessons\Lessons\Schemas\LessonInfolist;
use App\Filament\Resources\Lessons\Lessons\Tables\LessonsTable;
use App\Models\Lesson;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $navigationLabel = 'Lessons';

    protected static ?int $navigationSort = 5;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return LessonForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LessonInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LessonsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListLessons::route('/'),
            'create' => CreateLesson::route('/create'),
            'view' => ViewLesson::route('/{record}'),
            'edit' => EditLesson::route('/{record}/edit'),
        ];
    }
}

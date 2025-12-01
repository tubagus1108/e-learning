<?php

namespace App\Filament\Resources\Quizzes\Quizzes;

use App\Filament\Resources\Quizzes\Quizzes\Pages\CreateQuiz;
use App\Filament\Resources\Quizzes\Quizzes\Pages\EditQuiz;
use App\Filament\Resources\Quizzes\Quizzes\Pages\ListQuizzes;
use App\Filament\Resources\Quizzes\Quizzes\Pages\ViewQuiz;
use App\Filament\Resources\Quizzes\Quizzes\Schemas\QuizForm;
use App\Filament\Resources\Quizzes\Quizzes\Schemas\QuizInfolist;
use App\Filament\Resources\Quizzes\Quizzes\Tables\QuizzesTable;
use App\Models\Quiz;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?string $navigationLabel = 'Quizzes';

    protected static ?int $navigationSort = 7;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return QuizForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return QuizInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuizzesTable::configure($table);
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
            'index' => ListQuizzes::route('/'),
            'create' => CreateQuiz::route('/create'),
            'view' => ViewQuiz::route('/{record}'),
            'edit' => EditQuiz::route('/{record}/edit'),
        ];
    }
}

<?php

namespace App\Filament\Resources\Grades\Grades;

use App\Filament\Resources\Grades\Grades\Pages\CreateGrade;
use App\Filament\Resources\Grades\Grades\Pages\EditGrade;
use App\Filament\Resources\Grades\Grades\Pages\ListGrades;
use App\Filament\Resources\Grades\Grades\Pages\ViewGrade;
use App\Filament\Resources\Grades\Grades\Schemas\GradeForm;
use App\Filament\Resources\Grades\Grades\Schemas\GradeInfolist;
use App\Filament\Resources\Grades\Grades\Tables\GradesTable;
use App\Models\Grade;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?string $navigationLabel = 'Grades';

    protected static ?int $navigationSort = 8;

    public static function form(Schema $schema): Schema
    {
        return GradeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GradeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GradesTable::configure($table);
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
            'index' => ListGrades::route('/'),
            'create' => CreateGrade::route('/create'),
            'view' => ViewGrade::route('/{record}'),
            'edit' => EditGrade::route('/{record}/edit'),
        ];
    }
}

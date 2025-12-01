<?php

namespace App\Filament\Resources\Assignments\Assignments;

use App\Filament\Resources\Assignments\Assignments\Pages\CreateAssignment;
use App\Filament\Resources\Assignments\Assignments\Pages\EditAssignment;
use App\Filament\Resources\Assignments\Assignments\Pages\ListAssignments;
use App\Filament\Resources\Assignments\Assignments\Pages\ViewAssignment;
use App\Filament\Resources\Assignments\Assignments\Schemas\AssignmentForm;
use App\Filament\Resources\Assignments\Assignments\Schemas\AssignmentInfolist;
use App\Filament\Resources\Assignments\Assignments\Tables\AssignmentsTable;
use App\Models\Assignment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AssignmentResource extends Resource
{
    protected static ?string $model = Assignment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $navigationLabel = 'Assignments';

    protected static ?int $navigationSort = 6;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return AssignmentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AssignmentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AssignmentsTable::configure($table);
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
            'index' => ListAssignments::route('/'),
            'create' => CreateAssignment::route('/create'),
            'view' => ViewAssignment::route('/{record}'),
            'edit' => EditAssignment::route('/{record}/edit'),
        ];
    }
}

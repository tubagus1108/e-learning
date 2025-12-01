<?php

namespace App\Filament\Resources\Assignments\Assignments\Pages;

use App\Filament\Resources\Assignments\Assignments\AssignmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAssignments extends ListRecords
{
    protected static string $resource = AssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}

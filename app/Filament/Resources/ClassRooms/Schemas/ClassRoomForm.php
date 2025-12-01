<?php

namespace App\Filament\Resources\ClassRooms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClassRoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('grade_level')
                    ->required()
                    ->numeric(),
                Select::make('homeroom_teacher_id')
                    ->relationship('homeroomTeacher', 'id')
                    ->default(null),
                TextInput::make('academic_year')
                    ->required(),
            ]);
    }
}

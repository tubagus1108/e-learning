<?php

namespace App\Filament\Resources\Teachers\Schemas;

use App\Models\User;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Fieldset::make('Teacher Information')
                    ->schema([
                        Select::make('user_id')
                            ->label('User Account')
                            ->relationship('user', 'name')
                            ->options(User::where('role', 'teacher')->pluck('name', 'id'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('password')
                                    ->password()
                                    ->required()
                                    ->minLength(8)
                                    ->maxLength(255),
                            ])
                            ->helperText('Select existing teacher user or create new one'),
                        TextInput::make('nip')
                            ->label('NIP (Employee ID)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(20)
                            ->placeholder('Enter employee ID'),
                        TextInput::make('subject_specialty')
                            ->label('Subject Specialty')
                            ->maxLength(255)
                            ->placeholder('e.g., Mathematics, English, Science'),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('+62 812 3456 7890'),
                    ])
                    ->columns(2),
            ]);
    }
}

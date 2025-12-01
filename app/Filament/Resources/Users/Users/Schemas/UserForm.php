<?php

namespace App\Filament\Resources\Users\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Full Name'),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->placeholder('user@example.com'),

                        TextInput::make('password')
                            ->password()
                            ->required(fn (string $context): bool => $context === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->minLength(8)
                            ->maxLength(255)
                            ->placeholder('Minimum 8 characters')
                            ->helperText('Leave blank to keep current password when editing'),

                        Select::make('role')
                            ->required()
                            ->options([
                                'admin' => 'Administrator',
                                'teacher' => 'Teacher',
                                'student' => 'Student',
                                'parent' => 'Parent',
                            ])
                            ->default('student')
                            ->native(false)
                            ->searchable()
                            ->helperText('Assign user role for access control'),

                        Toggle::make('is_active')
                            ->label('Active Status')
                            ->default(true)
                            ->helperText('Inactive users cannot login'),
                    ])
                    ->columns(2),
            ]);
    }
}

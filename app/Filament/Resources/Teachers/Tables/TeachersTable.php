<?php

namespace App\Filament\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->toggleable(),
                TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->copyable(),
                TextColumn::make('subject_specialty')
                    ->label('Specialty')
                    ->searchable()
                    ->badge()
                    ->color('info'),
                TextColumn::make('phone')
                    ->label('Phone')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('subjects_count')
                    ->label('Subjects')
                    ->counts('subjects')
                    ->badge()
                    ->color('success'),
                TextColumn::make('homeroomClasses_count')
                    ->label('Homeroom Classes')
                    ->counts('homeroomClasses')
                    ->badge()
                    ->color('warning')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('subject_specialty')
                    ->label('Specialty')
                    ->options([
                        'Matematika' => 'Matematika',
                        'Bahasa Indonesia' => 'Bahasa Indonesia',
                        'Bahasa Inggris' => 'Bahasa Inggris',
                        'IPA' => 'IPA',
                        'IPS' => 'IPS',
                        'Seni Budaya' => 'Seni Budaya',
                        'Pendidikan Jasmani' => 'Pendidikan Jasmani',
                        'Agama' => 'Agama',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('user.name');
    }
}

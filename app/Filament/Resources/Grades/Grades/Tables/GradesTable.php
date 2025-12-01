<?php

namespace App\Filament\Resources\Grades\Grades\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class GradesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.user.name')
                    ->label('Student')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.student_id')
                    ->label('Student ID')
                    ->searchable(),
                TextColumn::make('subject.name')
                    ->label('Subject')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gradable_type')
                    ->label('Type')
                    ->formatStateUsing(fn ($state) => class_basename($state))
                    ->badge()
                    ->colors([
                        'primary' => 'Submission',
                        'success' => 'QuizAttempt',
                    ]),
                TextColumn::make('score')
                    ->sortable()
                    ->alignCenter()
                    ->color(fn ($record) => match (true) {
                        $record->score >= 90 => 'success',
                        $record->score >= 75 => 'primary',
                        $record->score >= 60 => 'warning',
                        default => 'danger'
                    }),
                TextColumn::make('feedback')
                    ->limit(50)
                    ->toggleable(),
                TextColumn::make('graded_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            ->defaultSort('graded_at', 'desc');
    }
}

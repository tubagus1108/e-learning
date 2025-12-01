<?php

namespace App\Filament\Resources\Quizzes\Quizzes\Pages;

use App\Filament\Resources\Quizzes\Quizzes\QuizResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuiz extends CreateRecord
{
    protected static string $resource = QuizResource::class;
}

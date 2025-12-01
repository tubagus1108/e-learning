<?php

namespace App\Filament\Resources\Lessons\Lessons\Pages;

use App\Filament\Resources\Lessons\Lessons\LessonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLesson extends CreateRecord
{
    protected static string $resource = LessonResource::class;
}

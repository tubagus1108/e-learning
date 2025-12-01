<?php

namespace App\Filament\Resources\Announcements\Announcements;

use App\Filament\Resources\Announcements\Announcements\Pages\CreateAnnouncement;
use App\Filament\Resources\Announcements\Announcements\Pages\EditAnnouncement;
use App\Filament\Resources\Announcements\Announcements\Pages\ListAnnouncements;
use App\Filament\Resources\Announcements\Announcements\Pages\ViewAnnouncement;
use App\Filament\Resources\Announcements\Announcements\Schemas\AnnouncementForm;
use App\Filament\Resources\Announcements\Announcements\Schemas\AnnouncementInfolist;
use App\Filament\Resources\Announcements\Announcements\Tables\AnnouncementsTable;
use App\Models\Notification;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Notification::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSpeakerWave;

    protected static ?string $navigationLabel = 'Announcements';

    protected static ?int $navigationSort = 10;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return AnnouncementForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return AnnouncementInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return AnnouncementsTable::configure($table);
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
            'index' => ListAnnouncements::route('/'),
            'create' => CreateAnnouncement::route('/create'),
            'view' => ViewAnnouncement::route('/{record}'),
            'edit' => EditAnnouncement::route('/{record}/edit'),
        ];
    }
}

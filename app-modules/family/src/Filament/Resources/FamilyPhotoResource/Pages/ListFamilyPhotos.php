<?php

namespace Dzorogh\Family\Filament\Resources\FamilyPhotoResource\Pages;

use Dzorogh\Family\Filament\Resources\FamilyPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamilyPhotos extends ListRecords
{
    protected static string $resource = FamilyPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

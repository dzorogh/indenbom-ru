<?php

namespace App\Modules\Family\Filament\Resources\FamilyPersonResource\Pages;

use App\Modules\Family\Filament\Resources\FamilyPersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamilyPeople extends ListRecords
{
    protected static string $resource = FamilyPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

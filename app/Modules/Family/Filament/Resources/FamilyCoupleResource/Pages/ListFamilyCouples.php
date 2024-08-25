<?php

namespace App\Modules\Family\Filament\Resources\FamilyCoupleResource\Pages;

use App\Modules\Family\Filament\Resources\FamilyCoupleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFamilyCouples extends ListRecords
{
    protected static string $resource = FamilyCoupleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

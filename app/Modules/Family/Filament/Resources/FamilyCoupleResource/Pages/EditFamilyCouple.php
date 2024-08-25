<?php

namespace App\Modules\Family\Filament\Resources\FamilyCoupleResource\Pages;

use App\Modules\Family\Filament\Resources\FamilyCoupleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFamilyCouple extends EditRecord
{
    protected static string $resource = FamilyCoupleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

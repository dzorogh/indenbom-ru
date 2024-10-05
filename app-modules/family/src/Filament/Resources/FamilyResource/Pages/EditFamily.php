<?php

namespace Dzorogh\Family\Filament\Resources\FamilyResource\Pages;

use Dzorogh\Family\Filament\Resources\FamilyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFamily extends EditRecord
{
    protected static string $resource = FamilyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

<?php

namespace Dzorogh\Family\Filament\Resources\FamilyPersonResource\Pages;

use Dzorogh\Family\Filament\Resources\FamilyPersonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFamilyPerson extends EditRecord
{
    protected static string $resource = FamilyPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => !$this->record->trashed()),
            Actions\RestoreAction::make()
                ->visible(fn () => $this->record->trashed()),
            Actions\ForceDeleteAction::make()
                ->visible(fn () => $this->record->trashed()),
        ];
    }
}

<?php

namespace Dzorogh\Family\Filament\Resources\FamilyPersonResource\Pages;

use Dzorogh\Family\Filament\Resources\FamilyPersonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListFamilyPeople extends ListRecords
{
    protected static string $resource = FamilyPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->withoutGlobalScopes()
            ->withTrashed();
    }
}

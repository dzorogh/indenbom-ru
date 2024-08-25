<?php

namespace App\Modules\Family\Filament\Resources\FamilyPersonResource\Pages;

use App\Modules\Family\Filament\Resources\FamilyPersonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFamilyPerson extends CreateRecord
{
    protected static string $resource = FamilyPersonResource::class;
}

<?php

namespace Dzorogh\Family\Filament\Resources\FamilyPersonResource\RelationManagers;

use Dzorogh\Family\Enums\ContactType;
use Dzorogh\Family\Enums\DatePrecision;
use Dzorogh\Family\Filament\Resources\FamilyCoupleResource;
use Dzorogh\Family\Filament\Resources\FamilyPersonResource;
use Dzorogh\Family\Filament\Resources\FamilyPhotoResource;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouplesWifeRelationManager extends RelationManager
{
    protected static string $relationship = 'couplesWife';

    protected static ?string $title = 'Couples (as wife)';

    public function form(Form $form): Form
    {
        return FamilyCoupleResource::form($form);
    }

    public function table(Table $table): Table
    {
        return FamilyCoupleResource::table($table);
    }
}

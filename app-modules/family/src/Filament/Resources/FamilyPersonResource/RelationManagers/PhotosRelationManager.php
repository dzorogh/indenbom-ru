<?php

namespace Dzorogh\Family\Filament\Resources\FamilyPersonResource\RelationManagers;

use Dzorogh\Family\Enums\ContactType;
use Dzorogh\Family\Enums\DatePrecision;
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

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    public function form(Form $form): Form
    {
        return FamilyPhotoResource::form($form);
    }

    public function table(Table $table): Table
    {
        return FamilyPhotoResource::table($table);
    }
}

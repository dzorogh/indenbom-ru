<?php

namespace Dzorogh\Family\Filament\Resources\FamilyPersonResource\RelationManagers;

use Dzorogh\Family\Enums\ContactType;
use Dzorogh\Family\Enums\DatePrecision;
use Filament\Forms;
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
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('media'),

                Forms\Components\Textarea::make('description')->autosize(),

                Forms\Components\TextInput::make('approximate_date')
                    ->maxLength(255),

                Forms\Components\TextInput::make('place')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->reorderable('order')
            ->recordTitleAttribute('value')
            ->columns([
                SpatieMediaLibraryImageColumn::make('media')->height(100),

                Tables\Columns\TextColumn::make('description')
                    ->width(400)
                    ->wrap()
                    ->lineClamp(2),
                Tables\Columns\TextColumn::make('place'),
                Tables\Columns\TextColumn::make('approximate_date'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

<?php

namespace Dzorogh\Family\Filament\Resources;

use Dzorogh\Family\Filament\Resources\FamilyPhotoResource\Pages;
use Dzorogh\Family\Filament\Resources\FamilyPhotoResource\RelationManagers\PeoplePhotosRelationManager;
use Dzorogh\Family\Models\FamilyPhoto;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;

class FamilyPhotoResource extends Resource
{
    protected static ?string $model = FamilyPhoto::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('media'),

                MarkdownEditor::make('description'),

                Forms\Components\TextInput::make('approximate_date')
                    ->maxLength(255),

                Forms\Components\TextInput::make('place')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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

    public static function getRelations(): array
    {
        return [
            PeoplePhotosRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFamilyPhotos::route('/'),
            'create' => Pages\CreateFamilyPhoto::route('/create'),
            'edit' => Pages\EditFamilyPhoto::route('/{record}/edit'),
        ];
    }
}

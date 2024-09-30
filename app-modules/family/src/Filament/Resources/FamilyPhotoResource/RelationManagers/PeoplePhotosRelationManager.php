<?php

namespace Dzorogh\Family\Filament\Resources\FamilyPhotoResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PeoplePhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'peoplePhotos';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\Select::make('family_person_id')
                    ->relationship(name: 'person', titleAttribute: 'full_name')
                    ->searchable(['full_name'])
                    ->preload(),

                Forms\Components\TextInput::make('position_on_photo'),

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('value')
            ->columns([
                Tables\Columns\TextColumn::make('person.full_name')
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

<?php

namespace Dzorogh\Family\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Dzorogh\Family\Models\FamilyCouple;
use Dzorogh\Family\Filament\Resources\FamilyCoupleResource\Pages;
use Dzorogh\Family\Filament\Resources\FamilyCoupleResource\Pages\CreateFamilyCouple;
use Dzorogh\Family\Filament\Resources\FamilyCoupleResource\Pages\EditFamilyCouple;
use Dzorogh\Family\Filament\Resources\FamilyCoupleResource\Pages\ListFamilyCouples;
use Dzorogh\Family\Filament\Resources\FamilyCoupleResource\RelationManagers;
use Dzorogh\Family\Filament\Resources\FamilyCoupleResource\RelationManagers\ChildrenRelationManager;

class FamilyCoupleResource extends Resource
{
    protected static ?string $model = FamilyCouple::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select First Person
                Forms\Components\Select::make('husband_id')
                    ->relationship(name: 'husband', titleAttribute: 'full_name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(function ($form) {
                        return FamilyPersonResource::form($form);
                    }),

                // Select Second Person
                Forms\Components\Select::make('wife_id')
                    ->relationship(name: 'wife', titleAttribute: 'full_name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(function ($form) {
                        return FamilyPersonResource::form($form);
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // First person
                Tables\Columns\TextColumn::make('husband.full_name'),

                // Second person
                Tables\Columns\TextColumn::make('wife.full_name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'children' => ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFamilyCouples::route('/'),
            'create' => CreateFamilyCouple::route('/create'),
            'edit' => EditFamilyCouple::route('/{record}/edit'),
        ];
    }
}

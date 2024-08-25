<?php

namespace App\Modules\Family\Filament\Resources;

use App\Filament\Resources\FamilyCoupleResource\Pages;
use App\Filament\Resources\FamilyCoupleResource\RelationManagers;
use App\Modules\Family\Models\FamilyCouple;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class FamilyCoupleResource extends Resource
{
    protected static ?string $model = FamilyCouple::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Select First Person
                Forms\Components\Select::make('first_person_id')
                    ->relationship(name: 'first_person', titleAttribute: 'full_name')
                    ->searchable()
                    ->preload()
                    ->createOptionForm(function ($form) {
                        return FamilyPersonResource::form($form);
                    }),

                // Select Second Person
                Forms\Components\Select::make('second_person_id')
                    ->relationship(name: 'second_person', titleAttribute: 'full_name')
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
                Tables\Columns\TextColumn::make('first_person.full_name'),

                // Second person
                Tables\Columns\TextColumn::make('second_person.full_name')
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
            'children' => \App\Modules\Family\Filament\Resources\FamilyCoupleResource\RelationManagers\ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Modules\Family\Filament\Resources\FamilyCoupleResource\Pages\ListFamilyCouples::route('/'),
            'create' => \App\Modules\Family\Filament\Resources\FamilyCoupleResource\Pages\CreateFamilyCouple::route('/create'),
            'edit' => \App\Modules\Family\Filament\Resources\FamilyCoupleResource\Pages\EditFamilyCouple::route('/{record}/edit'),
        ];
    }
}

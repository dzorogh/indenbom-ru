<?php

namespace App\Modules\Family\Filament\Resources;

use App\Modules\Family\Models\FamilyCouple;
use App\Modules\Family\Models\FamilyPerson;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FamilyPersonResource extends Resource
{
    protected static ?string $model = FamilyPerson::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make('Name')
                    ->columns([
                        'lg' => 3
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->columns(1),

                        Forms\Components\TextInput::make('middle_name')
                            ->columns(1),

                        Forms\Components\TextInput::make('last_name')
                            ->columns(1),
                    ]),

                Section::make('Birthdate')
                    ->columns([
                        'lg' => 4
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('decade_of_birth')
                            ->numeric()
                            ->minValue(0)
                            ->step(10),

                        Forms\Components\TextInput::make('year_of_birth')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(Carbon::now()->year),

                        Forms\Components\TextInput::make('month_of_birth')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(12),

                        Forms\Components\TextInput::make('day_of_birth')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(31),
                    ]),

                Section::make('Deathdate')
                    ->columns([
                        'lg' => 4
                    ])
                    ->schema([
                        Forms\Components\TextInput::make('decade_of_death')
                            ->numeric()
                            ->minValue(0)
                            ->step(10),

                        Forms\Components\TextInput::make('year_of_death')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(Carbon::now()->year),

                        Forms\Components\TextInput::make('month_of_death')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(12),

                        Forms\Components\TextInput::make('day_of_death')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(31),
                    ]),

                Select::make('parent_couple_id')
                    ->relationship(
                        name: 'parentCouple',
                        modifyQueryUsing: fn (Builder $query) => $query->with(['first_person', 'second_person']),
                    )
                    ->getOptionLabelFromRecordUsing(fn (FamilyCouple $record) => "{$record->first_person?->full_name} + {$record->second_person?->full_name}")
                    ->native(false)
                    ->preload()
                ,

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Modules\Family\Filament\Resources\FamilyPersonResource\Pages\ListFamilyPeople::route('/'),
            'create' => \App\Modules\Family\Filament\Resources\FamilyPersonResource\Pages\CreateFamilyPerson::route('/create'),
            'edit' => \App\Modules\Family\Filament\Resources\FamilyPersonResource\Pages\EditFamilyPerson::route('/{record}/edit'),
        ];
    }
}

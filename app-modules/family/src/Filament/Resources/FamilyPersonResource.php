<?php

namespace Dzorogh\Family\Filament\Resources;

use Dzorogh\Family\Enums\DatePrecision;
use Dzorogh\Family\Filament\Resources\FamilyPersonResource\Pages\CreateFamilyPerson;
use Dzorogh\Family\Filament\Resources\FamilyPersonResource\Pages\EditFamilyPerson;
use Dzorogh\Family\Filament\Resources\FamilyPersonResource\Pages\ListFamilyPeople;
use Dzorogh\Family\Filament\Resources\FamilyPersonResource\RelationManagers\ContactsRelationManager;
use Dzorogh\Family\Filament\Resources\FamilyPersonResource\RelationManagers\CouplesHusbandRelationManager;
use Dzorogh\Family\Filament\Resources\FamilyPersonResource\RelationManagers\CouplesWifeRelationManager;
use Dzorogh\Family\Filament\Resources\FamilyPersonResource\RelationManagers\PhotosRelationManager;
use Dzorogh\Family\Models\FamilyCouple;
use Dzorogh\Family\Models\FamilyPerson;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;


class FamilyPersonResource extends Resource
{
    protected static ?string $model = FamilyPerson::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Form $form ): Form
    {
        return $form
            ->schema([
                SpatieMediaLibraryFileUpload::make('avatar')
                    ->collection('avatar')
                    ->avatar()
                    ->imageEditor()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->maxSize(10240),

                Section::make('Parents')
                    ->schema([
                        Select::make('parent_couple_id')
                            ->searchable()
                            ->relationship(
                                name: 'parentCouple',
                                modifyQueryUsing: fn(Builder $query) => $query->with(['husband', 'wife']),
                            )
                            ->getOptionLabelFromRecordUsing(fn(FamilyCouple $record) => "{$record->husband?->full_name} + {$record->wife?->full_name}")
                            ->native(false)
                            ->preload(),
                    ]),

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

                Section::make('Birth')
                    ->schema([

                        Forms\Components\TextInput::make('place_of_birth'),

                        DatePicker::make('birth_date'),


                        Radio::make('birth_date_precision')
                            ->options(DatePrecision::class)
                            ->inline()
                            ->inlineLabel(false)
                            ->default(DatePrecision::Exact)
                    ]),

                Section::make('Death')
                    ->schema([
                        DatePicker::make('death_date'),

                        Radio::make('death_date_precision')
                            ->options(DatePrecision::class)
                            ->inline()
                            ->inlineLabel(false)
                            ->default(DatePrecision::Exact)
                    ]),

                MarkdownEditor::make('article'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (FamilyPerson $record): string => $record->trashed() ? 'Удалено' : '')
                    ->color(fn (FamilyPerson $record): string => $record->trashed() ? 'danger' : 'primary'),

                Tables\Columns\TextColumn::make('birth_date')
                    ->sortable(),

                Tables\Columns\TextColumn::make('death_date')
                    ->sortable(),

                Tables\Columns\TextColumn::make('deleted_at')
                    ->label('Статус')
                    ->formatStateUsing(fn ($state): string => $state ? 'Удалено' : 'Активно')
                    ->color(fn ($state): string => $state ? 'danger' : 'success')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(fn (FamilyPerson $record): bool => !$record->trashed()),
                Tables\Actions\RestoreAction::make()
                    ->visible(fn (FamilyPerson $record): bool => $record->trashed()),
                Tables\Actions\ForceDeleteAction::make()
                    ->visible(fn (FamilyPerson $record): bool => $record->trashed()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ContactsRelationManager::class,
            PhotosRelationManager::class,
            CouplesHusbandRelationManager::class,
            CouplesWifeRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFamilyPeople::route('/'),
            'create' => CreateFamilyPerson::route('/create'),
            'edit' => EditFamilyPerson::route('/{record}/edit'),
        ];
    }
}

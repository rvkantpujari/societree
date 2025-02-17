<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocietyResource\Pages;
use App\Filament\Resources\SocietyResource\RelationManagers;
use App\Filament\Resources\SocietyResource\RelationManagers\BlocksRelationManager;
use App\Models\Country;
use App\Models\State;
use App\Models\Society;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class SocietyResource extends Resource
{
    protected static ?string $model = Society::class;

    protected static ?string $navigationGroup = 'Society Management';

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create Society')
                    ->description('Add details such as name, number of units, address and description.')
                    ->icon('heroicon-m-building-office-2')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(debounce: 800) // Enables live updates with slight delay
                            // ->afterStateUpdated(
                            //     fn($state, callable $set) =>
                            //     $set('slug', Str::slug($state))
                            // )
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $existingSlug = $get('slug');

                                // Extract random key from existing slug if available
                                $randomKey = Str::afterLast($existingSlug, '-') ?: Str::random(16);

                                // Generate new slug with retained random key
                                $set('slug', Str::slug($state) . '-' . $randomKey);
                            })
                            ->autofocus()
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 6,
                            ]),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->disabled()
                            // ->dehydrated(false) // Prevents from being submitted manually
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 6,
                            ]),
                        // Store random_slug_key but keep it hidden from the form
                        Forms\Components\TextInput::make('random_slug_key')
                            ->dehydrated() // Ensures it is saved in the database
                            ->default(fn() => Str::random(16)) // Generate only if new record
                            ->hidden(),
                        Forms\Components\TextInput::make('number_of_units')
                            ->numeric()
                            ->required()
                            ->maxLength(255)
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 4,
                            ]),
                        Forms\Components\TextInput::make('street')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 4,
                            ]),
                        Forms\Components\TextInput::make('landmark')
                            ->nullable()
                            ->maxLength(255)
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 4,
                            ]),
                        Forms\Components\TextInput::make('area')
                            ->alpha()
                            ->maxLength(255)
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 3,
                            ]),
                        Forms\Components\TextInput::make('city')
                            ->alpha()
                            ->maxLength(255)
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 3,
                            ]),
                        Forms\Components\Select::make('state_id')
                            ->label('State')
                            ->options(State::pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(
                                fn(Forms\Get $get, Forms\Set $set) =>
                                $set('country_name', State::find($get('state_id'))?->country->name)
                            )
                            ->required()
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 3,
                            ]),
                        Forms\Components\TextInput::make('country_name')
                            ->label('Country')
                            ->disabled()
                            ->dehydrated(false) // Prevent saving to the database
                            ->formatStateUsing(
                                fn($state, Forms\Get $get) =>
                                State::find($get('state_id'))?->country->name
                            )
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 3,
                            ]),
                        Forms\Components\RichEditor::make('description')
                            ->toolbarButtons([
                                'blockquote',
                                'bold',
                                'bulletList',
                                'h1',
                                'h2',
                                'h3',
                                'italic',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->disableGrammarly()
                            ->nullable()
                            ->columnSpanFull(),
                    ])->columns([
                        'sm' => 1,
                        'md' => 3,
                        'lg' => 6,
                        'xl' => 9,
                        '2xl' => 12
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Society Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_units')
                    ->label('Total Units')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('street')
                    ->label('Street Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('landmark')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('area')
                    ->label('Area')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('City')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('state.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('state.country.name')->label('Country')->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->dateTimeTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->sinceTooltip()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            BlocksRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocieties::route('/'),
            'create' => Pages\CreateSociety::route('/create'),
            'edit' => Pages\EditSociety::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('state.country') // Eager load state and country for efficient querying
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

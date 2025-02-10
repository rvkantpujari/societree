<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([])
                    ->schema([
                        Split::make([
                            Grid::make()
                                ->schema([
                                    Forms\Components\TextInput::make('first_name')
                                        ->required()
                                        ->maxLength(255)
                                        ->columnSpan([
                                            'sm' => 1,
                                            'md' => 2,
                                            'lg' => 4,
                                            'xl' => 5
                                        ]),
                                    Forms\Components\TextInput::make('middle_name')
                                        ->maxLength(255)
                                        ->default(null)
                                        ->columnSpan([
                                            'sm' => 1,
                                            'md' => 2,
                                            'lg' => 4,
                                            'xl' => 5
                                        ]),
                                    Forms\Components\TextInput::make('last_name')
                                        ->required()
                                        ->maxLength(255)
                                        ->columnSpan([
                                            'sm' => 1,
                                            'md' => 2,
                                            'lg' => 4,
                                            'xl' => 5
                                        ]),
                                    Forms\Components\DatePicker::make('date_of_birth')
                                        ->columnSpan([
                                            'sm' => 1,
                                            'md' => 2,
                                            'lg' => 4,
                                            'xl' => 5
                                        ]),
                                    Forms\Components\TextInput::make('phone')
                                        ->tel()
                                        ->maxLength(255)
                                        ->default(null)
                                        ->columnSpan([
                                            'sm' => 1,
                                            'md' => 2,
                                            'lg' => 4,
                                            'xl' => 5
                                        ]),
                                    Forms\Components\TextInput::make('email')
                                        ->email()
                                        ->required()
                                        ->maxLength(255)
                                        ->columnSpan([
                                            'sm' => 1,
                                            'md' => 2,
                                            'lg' => 4,
                                            'xl' => 5
                                        ]),
                                    Forms\Components\TextInput::make('password')
                                        ->password()
                                        ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                        ->dehydrated(fn(?string $state): bool => filled($state))
                                        ->required(fn(string $operation): bool => $operation === 'create')
                                        ->revealable()
                                        ->maxLength(32)
                                        ->columnSpan([
                                            'sm' => 1,
                                            'md' => 2,
                                            'lg' => 4,
                                            'xl' => 5
                                        ]),
                                ])->columns([
                                    'sm' => 1,
                                    'md' => 6,
                                    'lg' => 12,
                                    'xl' => 15,
                                ]),

                            Section::make([
                                Forms\Components\FileUpload::make('profile_image')
                                    ->label('Photo ID')
                                    ->image(),
                            ])
                        ])->from('lg')
                    ])

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('middle_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sinceTooltip()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Tables\Filters\Filter::make('email_verified')
                    ->query(fn(Builder $query): Builder => $query->where('email_verified_at', '!=', NULL))
                    ->toggle()
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

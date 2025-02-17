<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlockResource\Pages;
use App\Filament\Resources\BlockResource\RelationManagers;
use App\Models\Block;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Validation\Rule;

class BlockResource extends Resource
{
    protected static ?string $model = Block::class;

    protected static ?string $navigationGroup = 'Society Management';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Create or Edit Block')
                    ->description('Add or update details such as name and description.')
                    ->icon('heroicon-m-building-office')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Equivalent to floor level such as basement.')
                            ->label('Block')
                            ->required()
                            ->unique(ignoreRecord: true, modifyRuleUsing: function ($rule, $get) {
                                return Rule::unique('blocks', 'name')
                                    ->where('society_id', $get('society_id'))
                                    ->ignore($get('id'));
                            })
                            ->maxLength(255)->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 6,
                            ]),
                        Forms\Components\Select::make('society_id')
                            ->label('Society')
                            ->preload()
                            ->relationship('society', 'name')
                            ->searchable()
                            ->required()
                            ->columnSpan([
                                'sm' => 1,
                                'md' => 2,
                                'lg' => 6,
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
                            ->default('')
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
                    ->label('Block')
                    ->searchable(),
                Tables\Columns\TextColumn::make('society.name')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
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
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort(function (Builder $query): Builder {
                return $query
                    ->orderBy('society_id')
                    ->orderBy('name');
            })
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlocks::route('/'),
            'create' => Pages\CreateBlock::route('/create'),
            'edit' => Pages\EditBlock::route('/{record}/edit'),
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

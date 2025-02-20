<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\State;
use Filament\Forms\Components\Section;
use Illuminate\Support\Str;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\EditTenantProfile;

class EditSocietyProfile extends EditTenantProfile
{
    public static function getLabel(): string
    {
        return 'Society profile';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Edit Society Profile')
                    ->description('Update details such as name, total units, address and description.')
                    ->icon('heroicon-m-building-office-2')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(debounce: 800) // Enables live updates with slight delay
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
}

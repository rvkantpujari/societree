<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Society;
use App\Models\State;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Pages\Tenancy\RegisterTenant;
use Illuminate\Support\Facades\Auth;

class RegisterSociety extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Register Society';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make()
                    ->schema([
                        TextInput::make('name')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, callable $get, callable $set) {
                                $existingSlug = $get('slug');

                                // Extract random key from existing slug if available
                                $randomKey = Str::afterLast($existingSlug, '-') ?: Str::random(16);

                                // Generate new slug with retained random key
                                $set('slug', Str::slug($state) . '-' . $randomKey);
                            })
                            ->autofocus()
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('number_of_units')
                            ->label('Total Units')
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('street')
                            ->required()
                            ->maxLength(255),
                        Select::make('state_id')
                            ->label('State')
                            ->options(State::pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(
                                fn(Get $get, Set $set) =>
                                $set('country_name', State::find($get('state_id'))?->country->name)
                            )
                            ->required(),
                        TextInput::make('country_name')
                            ->label('Country')
                            ->disabled()
                            ->dehydrated(false) // Prevent saving to the database
                            ->formatStateUsing(
                                fn($state, Get $get) =>
                                State::find($get('state_id'))?->country->name
                            ),
                        TextInput::make('slug')
                            ->disabled()
                            ->hidden(),
                        // Store random_slug_key but keep it hidden from the form
                        TextInput::make('random_slug_key')
                            ->dehydrated() // Ensures it is saved in the database
                            ->default(fn() => Str::random(16)) // Generate only if new record
                            ->hidden(),
                    ])
                    ->columns(2)
            ]);
    }

    protected function handleRegistration(array $data): Society
    {
        $society = Society::create($data);

        $society->members()->attach(Auth::user());

        return $society;
    }
}

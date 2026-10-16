<?php

namespace App\Filament\Resources\Countries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CountryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('country_name')
                    ->unique()
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('country_code')
                    ->unique()
                    ->required()
                    ->maxLength(255)
                    ->columns(1),
                TextInput::make('country_phone_code')
                    ->tel()
                    ->required()
                    ->numeric()
                    ->columns(1),
            ]);
    }
}

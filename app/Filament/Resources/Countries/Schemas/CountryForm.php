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
                TextInput::make('name')
                    ->unique()
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                TextInput::make('code')
                    ->unique()
                    ->required()
                    ->maxLength(255)
                    ->columns(1),
                TextInput::make('phone_code')
                    ->tel()
                    ->required()
                    ->numeric()
                    ->columns(1),
            ])->columns([
                'sm' => 1,
                'md' => 2,
                'lg' => 2,
            ]);
    }
}

<?php

namespace App\Filament\Pages\Tenancy;

use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
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
                TextInput::make('name')
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Set $set, $state) {
                        $set('slug', Str::slug($state));
                    })
                    ->required(),
                TextInput::make('number_of_units')
                    ->required(),
                TextInput::make('address')
                    ->required()
                    ->maxLength(255),
                TextInput::make('country')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->required(),
            ]);
    }
}

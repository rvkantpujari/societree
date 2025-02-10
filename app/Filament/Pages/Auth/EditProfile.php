<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Fieldset::make('Personal Details')->schema([

                            TextInput::make('first_name')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan([
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 4,
                                ]),
                            TextInput::make('middle_name')
                                ->maxLength(255)
                                ->columnSpan([
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 4,
                                ]),
                            TextInput::make('last_name')
                                ->required()
                                ->maxLength(255)
                                ->columnSpan([
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 4,
                                ]),
                            DatePicker::make('date_of_birth')
                                ->columnSpan([
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 4,
                                ]),
                            TextInput::make('phone')
                                ->tel()
                                ->columnSpan([
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 4,
                                ]),
                        ])->columns([
                            'sm' => 1,
                            'md' => 4,
                            'lg' => 8,
                            'xl' => 12
                        ]),
                        Fieldset::make('Account Details')->schema([
                            TextInput::make('email')
                                ->label(__('filament-panels::pages/auth/edit-profile.form.email.label'))
                                ->email()
                                ->required()
                                ->maxLength(255)
                                ->unique(ignoreRecord: true)
                                ->columnSpan([
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 6,
                                ]),
                            TextInput::make('password')
                                ->label(__('filament-panels::pages/auth/edit-profile.form.password.label'))
                                ->password()
                                ->revealable(filament()->arePasswordsRevealable())
                                ->rule(Password::default())
                                ->autocomplete('new-password')
                                ->dehydrated(fn($state): bool => filled($state))
                                ->dehydrateStateUsing(fn($state): string => Hash::make($state))
                                ->live(debounce: 500)
                                // ->same('passwordConfirmation')
                                ->columnSpan([
                                    'sm' => 1,
                                    'md' => 2,
                                    'lg' => 6,
                                ]),
                            // TextInput::make('passwordConfirmation')
                            //     ->label(__('filament-panels::pages/auth/edit-profile.form.password_confirmation.label'))
                            //     ->password()
                            //     ->revealable(filament()->arePasswordsRevealable())
                            //     ->required()
                            //     ->visible(fn(Get $get): bool => filled($get('password')))
                            //     ->dehydrated(false)
                            //     ->columnSpan([
                            //         'sm' => 1,
                            //         'md' => 2,
                            //         'lg' => 6,
                            //     ]),
                        ])
                            ->columns([
                                'sm' => 1,
                                'md' => 3,
                                'lg' => 6,
                                'xl' => 9,
                                '2xl' => 12
                            ]),
                    ])->columns([
                        'sm' => 1,
                        'md' => 3,
                        'lg' => 6,
                        'xl' => 9,
                        '2xl' => 12
                    ])
            ]);
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Profile Updated')
            ->body('Your profile has been updated successfully.');
    }
}

<?php

namespace App\Filament\App\Resources\UserResource\Pages\Auth;

use App\Models\User;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Register extends BaseRegister
{
    public function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Grid::make()
                            ->schema([
                                TextInput::make('first_name')
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus()
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 4,
                                        'lg' => 6,
                                        'xl' => 8,
                                    ]),
                                TextInput::make('last_name')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan([
                                        'sm' => 1,
                                        'md' => 4,
                                        'lg' => 6,
                                        'xl' => 8,
                                    ]),
                                TextInput::make('email')
                                    ->email()
                                    ->unique(User::class, 'email')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                TextInput::make('password')
                                    ->password()
                                    ->dehydrateStateUsing(fn(string $state): string => Hash::make($state))
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->revealable()
                                    ->minLength(8)
                                    ->maxLength(32)
                                    ->required()
                                    ->columnSpanFull(),
                            ])
                            ->columns([
                                'sm' => 1,
                                'md' => 8,
                                'lg' => 12,
                                'xl' => 16,
                            ])
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    protected function handleRegistration(array $data): User
    {
        $user = new User();

        Model::withoutEvents(function () use ($data) {
            global $user;
            $user = User::create($data);
        });

        return $user;
    }
}

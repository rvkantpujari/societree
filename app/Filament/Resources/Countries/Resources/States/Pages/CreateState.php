<?php

namespace App\Filament\Resources\Countries\Resources\States\Pages;

use App\Filament\Resources\Countries\Resources\States\StateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateState extends CreateRecord
{
    protected static string $resource = StateResource::class;

    protected static ?string $title = 'Add State, Province or Territory';
}

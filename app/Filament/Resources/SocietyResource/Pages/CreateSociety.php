<?php

namespace App\Filament\Resources\SocietyResource\Pages;

use App\Filament\Resources\SocietyResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateSociety extends CreateRecord
{
    protected static string $resource = SocietyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('New Society Added')
            ->body('The society has been added successfully.');
    }
}

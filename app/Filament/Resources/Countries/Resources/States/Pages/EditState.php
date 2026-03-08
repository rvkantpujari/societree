<?php

namespace App\Filament\Resources\Countries\Resources\States\Pages;

use App\Filament\Resources\Countries\Resources\States\StateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditState extends EditRecord
{
    protected static string $resource = StateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        if (! $this->record->wasChanged()) {
            Notification::make()
                ->title('No changes detected')
                ->warning()
                ->send();

            $this->halt();
        }
    }
}

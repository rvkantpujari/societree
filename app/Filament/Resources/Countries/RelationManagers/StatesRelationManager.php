<?php

namespace App\Filament\Resources\Countries\RelationManagers;

use App\Filament\Resources\Countries\Resources\States\StateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class StatesRelationManager extends RelationManager
{
    protected static string $relationship = 'states';

    protected static ?string $relatedResource = StateResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->heading('States, Provinces or Territories')
            ->headerActions([
                CreateAction::make()->label('Add'),
            ]);
    }
}

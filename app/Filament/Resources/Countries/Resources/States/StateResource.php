<?php

namespace App\Filament\Resources\Countries\Resources\States;

use App\Filament\Resources\Countries\CountryResource;
use App\Filament\Resources\Countries\Resources\States\Pages\CreateState;
use App\Filament\Resources\Countries\Resources\States\Pages\EditState;
use App\Filament\Resources\Countries\Resources\States\Schemas\StateForm;
use App\Filament\Resources\Countries\Resources\States\Tables\StatesTable;
use App\Models\State;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StateResource extends Resource
{
    protected static ?string $model = State::class;

    protected static ?int $navigationSort = 2;

    protected static string | UnitEnum | null $navigationGroup = 'System Management';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;

    protected static ?string $parentResource = CountryResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return StateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateState::route('/create'),
            'edit' => EditState::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

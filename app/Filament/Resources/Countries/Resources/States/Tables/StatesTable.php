<?php

namespace App\Filament\Resources\Countries\Resources\States\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class StatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->description('Manage all states, provinces or territories belonging to this country.')
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()->slideOver(),
                EditAction::make()
                    ->modal()
                    ->slideOver()
                    ->using(function ($record, array $data, $action) {
                        // Check if any field changed
                        $dirty = collect($data)
                            ->filter(fn($value, $key) => $record->$key != $value)
                            ->isNotEmpty();

                        if (! $dirty) {
                            Notification::make()
                                ->title('No changes detected')
                                ->warning()
                                ->send();

                            $action->halt();
                            return;
                        }

                        $record->update($data);
                    }),
                DeleteAction::make()->modal()->slideOver(),
                ForceDeleteAction::make()->modal()->slideOver(),
                RestoreAction::make()->modal()->slideOver(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()->slideOver(),
                    ForceDeleteBulkAction::make()->slideOver(),
                    RestoreBulkAction::make()->slideOver(),
                ]),
            ]);
    }
}

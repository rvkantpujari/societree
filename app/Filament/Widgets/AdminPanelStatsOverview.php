<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminPanelStatsOverview extends BaseWidget
{
    protected ?string $heading = 'Analytics';

    protected ?string $description = 'An overview of statistics.';

    protected function getStats(): array
    {
        return [
            Stat::make('Users', count(User::all()) - 1)
                ->description('Total Registered Users')
                ->descriptionIcon('heroicon-m-users', IconPosition::Before),
        ];
    }
}

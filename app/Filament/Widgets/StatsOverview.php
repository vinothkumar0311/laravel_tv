<?php

namespace App\Filament\Widgets;

use App\Models\Channel;
use App\Models\Payment;
use App\Models\User;
use App\Models\UserSubscription;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Users', User::count())
                ->description('Registered users')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Channels', Channel::where('status', true)->count())
                ->description('Active channels')
                ->descriptionIcon('heroicon-m-tv')
                ->color('success'),

            Stat::make('Active Subscriptions', UserSubscription::where('status', 'active')->where('end_date', '>=', now())->count())
                ->description('Current subscribers')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('warning'),

            Stat::make('Revenue', '₹' . number_format(Payment::where('status', 'completed')->sum('amount'), 2))
                ->description('Total payments')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}

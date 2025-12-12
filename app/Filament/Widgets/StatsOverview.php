<?php

namespace App\Filament\Widgets;

use App\Models\Faq;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

    class StatsOverview extends BaseWidget
    {
        protected static ?string $pollingInterval = '15s';

        protected function getStats(): array
        {
            return [
                Stat::make('Total Layanan', Service::count())
                    ->description('Paket tersedia')
                    ->descriptionIcon('heroicon-m-server')
                    ->color('primary')
                    ->chart([7, 2, 10, 3, 15, 4, 17]),

                Stat::make('Portofolio', Portfolio::count())
                    ->description('Proyek selesai')
                    ->descriptionIcon('heroicon-m-photo')
                    ->color('success')
                    ->chart([15, 4, 10, 2, 12, 4, 12]),

                Stat::make('FAQ Active', Faq::where('is_active', true)->count())
                    ->description('Pertanyaan umum')
                    ->descriptionIcon('heroicon-m-question-mark-circle')
                    ->color('warning'),

                Stat::make('Total Admin', User::count())
                    ->description('Pengelola sistem')
                    ->descriptionIcon('heroicon-m-users')
                    ->color('danger'),
            ];
        }
    }

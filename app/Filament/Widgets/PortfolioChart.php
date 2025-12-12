<?php

namespace App\Filament\Widgets;

use App\Models\Portfolio;
use Filament\Widgets\ChartWidget;

class PortfolioChart extends ChartWidget
{
    protected static ?string $heading = 'Kategori Portofolio';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {

        $webCount = Portfolio::where('category', 'Web Development')->count();
        $mobileCount = Portfolio::where('category', 'Mobile App')->count();
        $uiuxCount = Portfolio::where('category', 'UI/UX Design')->count();
        $iotCount = Portfolio::where('category', 'IoT')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Proyek',
                    'data' => [$webCount, $mobileCount, $uiuxCount, $iotCount],
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    'borderColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 206, 86)',
                        'rgb(75, 192, 192)',
                    ],
                    'borderWidth' => 4,
                ],
            ],
            'labels' => ['Web Dev', 'Mobile App', 'UI/UX', 'IoT'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

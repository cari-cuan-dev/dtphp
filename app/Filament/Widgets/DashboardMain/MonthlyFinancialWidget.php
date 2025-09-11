<?php

namespace App\Filament\Widgets\DashboardMain;

use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;

class MonthlyFinancialWidget extends ChartWidget
{
    protected ?string $heading = 'Monthly Financial';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Alokasi',
                    'data' => [
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                    ],
                    'backgroundColor' => [
                        Color::Cyan[500],
                    ],
                    'borderColor' => [
                        Color::Cyan[700],
                    ],
                ],
                [
                    'label' => 'Realization',
                    'data' => [
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                        rand(1000000, 1000000000),
                    ],
                    'backgroundColor' => [
                        Color::Red[500]
                    ],
                    'borderColor' => [
                        Color::Red[700]
                    ],
                ],
            ],
            'labels' => [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'Mei',
                'Jun',
                'Jul',
                'Agu',
                'Sep',
                'Okt',
                'Nov',
                'Des',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}

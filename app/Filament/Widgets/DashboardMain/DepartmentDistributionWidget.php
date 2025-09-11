<?php

namespace App\Filament\Widgets\DashboardMain;

use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;

class DepartmentDistributionWidget extends ChartWidget
{
    protected ?string $heading = 'Department Distribution';

    protected ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => true,
                'position' => 'right'
            ],
            "datalabels" => [
                "display" => false
            ]
        ],
    ];

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan',
                    'data' => [
                        rand(10, 50),
                        rand(10, 50),
                        rand(10, 50),
                        rand(10, 50),
                        rand(10, 50),
                    ],
                    'backgroundColor' => [
                        Color::Cyan[500],
                        Color::Red[500],
                        Color::Emerald[500],
                        Color::Fuchsia[500],
                        Color::Amber[500],
                    ],
                    // 'borderColor' => '#9BD0F5',
                    'borderColor' => [
                        Color::Cyan[700],
                        Color::Red[700],
                        Color::Emerald[700],
                        Color::Fuchsia[700],
                        Color::Amber[700],
                    ],
                ],
            ],
            'labels' => [
                'Sales',
                'Marketing',
                'Support',
                'HR',
                'Development',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
        // return 'bar';
    }
}

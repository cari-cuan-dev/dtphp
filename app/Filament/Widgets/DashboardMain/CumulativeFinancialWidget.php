<?php

namespace App\Filament\Widgets\DashboardMain;

use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;

class CumulativeFinancialWidget extends ChartWidget
{
    protected ?string $heading = 'Cumulative Financial';

    protected function getData(): array
    {
        $data[0][0] = rand(100000, 1000000);
        $data[0][1] = $data[0][0] + rand(100000, 1000000);
        $data[0][2] = $data[0][1] + rand(100000, 1000000);
        $data[0][3] = $data[0][2] + rand(100000, 1000000);
        $data[0][4] = $data[0][3] + rand(100000, 1000000);
        $data[0][5] = $data[0][4] + rand(100000, 1000000);
        $data[0][6] = $data[0][5] + rand(100000, 1000000);
        $data[0][7] = $data[0][6] + rand(100000, 1000000);
        $data[0][8] = $data[0][7] + rand(100000, 1000000);
        $data[0][9] = $data[0][8] + rand(100000, 1000000);
        $data[0][10] = $data[0][9] + rand(100000, 1000000);
        $data[0][11] = $data[0][10] + rand(100000, 1000000);

        $data[1][0] = rand(100000, 1000000);
        $data[1][1] = $data[1][0] + rand(100000, 1000000);
        $data[1][2] = $data[1][1] + rand(100000, 1000000);
        $data[1][3] = $data[1][2] + rand(100000, 1000000);
        $data[1][4] = $data[1][3] + rand(100000, 1000000);
        $data[1][5] = $data[1][4] + rand(100000, 1000000);
        $data[1][6] = $data[1][5] + rand(100000, 1000000);
        $data[1][7] = $data[1][6] + rand(100000, 1000000);
        $data[1][8] = $data[1][7] + rand(100000, 1000000);
        $data[1][9] = $data[1][8] + rand(100000, 1000000);
        $data[1][10] = $data[1][9] + rand(100000, 1000000);
        $data[1][11] = $data[1][10] + rand(100000, 1000000);

        return [
            'datasets' => [
                [
                    'label' => 'Alokasi Kumulatif',
                    'data' => [
                        $data[0][0],
                        $data[0][1],
                        $data[0][2],
                        $data[0][3],
                        $data[0][4],
                        $data[0][5],
                        $data[0][6],
                        $data[0][7],
                        $data[0][8],
                        $data[0][9],
                        $data[0][10],
                        $data[0][11],
                    ],
                    'backgroundColor' => [
                        Color::Cyan[500],
                    ],
                    'borderColor' => [
                        Color::Cyan[700],
                    ],
                ],
                [
                    'label' => 'Realisasi Kumulatif',
                    'data' => [
                        $data[1][0],
                        $data[1][1],
                        $data[1][2],
                        $data[1][3],
                        $data[1][4],
                        $data[1][5],
                        $data[1][6],
                        $data[1][7],
                        $data[1][8],
                        $data[1][9],
                        $data[1][10],
                        $data[1][11],
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

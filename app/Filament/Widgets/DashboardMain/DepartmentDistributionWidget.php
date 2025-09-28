<?php

namespace App\Filament\Widgets\DashboardMain;

use App\Models\Activity;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class DepartmentDistributionWidget extends ChartWidget
{
    // protected ?string $heading = 'Department Distribution';
    use InteractsWithPageFilters;
    protected ?string $pollingInterval = null;

    public function getHeading(): string
    {
        return __('Role Distribution');
    }

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

        $snapshot = json_decode(request()->get('components')[0]['snapshot']);
        $year = $snapshot->data->pageFilters[0]?->year ?? null;
        $roles = $snapshot->data->pageFilters[0]?->role[0] ?? [];

        $allocations = Activity::join('components', 'components.activity_id', '=', 'activities.id')
            ->join('roles', 'roles.id', '=', 'activities.role_id')
            ->selectRaw('
                    roles.name as label,
                    sum(components.allocation_total) as data
                ')
            ->groupBy('roles.name')
            ->when($year, fn($query) => $query->where('activities.year', $year))
            ->when(!empty($roles), fn($query) => $query->whereIn('roles.uuid', $roles))
            ->get();

        $allocationLabel = $allocations->map(fn($value, $key) => $value->label);
        $allocationData = $allocations->map(fn($value, $key) => $value->data);

        $realizations = Activity::join('components', 'components.activity_id', '=', 'activities.id')
            ->join('reports', 'reports.component_id', '=', 'components.id')
            ->join('roles', 'roles.id', '=', 'activities.role_id')

            ->selectRaw('
                    roles.name as label,
                    sum(reports.realization_good
                        + reports.realization_social
                        + reports.realization_capital
                        + reports.realization_employee) as data
            ')
            ->groupBy('roles.name')
            ->when($year, fn($query) => $query->where('activities.year', $year))
            ->when(!empty($roles), fn($query) => $query->whereIn('roles.uuid', $roles))
            ->get();

        $realizationLabel = $realizations->map(fn($value, $key) => $value->label);
        $realizationData = $realizations->map(fn($value, $key) => $value->data);

        return [
            'datasets' => [
                [
                    'label' => 'Total Alokasi',
                    'data' => $allocationData,
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
                [
                    'label' => 'Total Realization',
                    'data' => $realizationData,
                    'backgroundColor' => [
                        Color::Cyan[300],
                        Color::Red[300],
                        Color::Emerald[300],
                        Color::Fuchsia[300],
                        Color::Amber[300],
                    ],
                    // 'borderColor' => '#9BD0F5',
                    'borderColor' => [
                        Color::Cyan[500],
                        Color::Red[500],
                        Color::Emerald[500],
                        Color::Fuchsia[500],
                        Color::Amber[500],
                    ],
                ],
            ],
            'labels' => $allocationLabel,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
        // return 'bar';
    }
}

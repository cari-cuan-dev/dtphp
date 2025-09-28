<?php

namespace App\Filament\Widgets\DashboardMain;

use App\Models\Activity;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Number;

class MonthlyFinancialWidget extends ChartWidget
{
    // protected ?string $heading = 'Monthly Financial';
    use InteractsWithPageFilters;
    protected ?string $pollingInterval = null;

    public function getHeading(): string
    {
        return __('Monthly Financial');
    }

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

        $allocationLabel = $allocations->map(fn($value, $key) => $value->label)[0];
        $allocationData = $allocations->map(fn($value, $key) => $value->data)[0];

        $realizations = Activity::join('components', 'components.activity_id', '=', 'activities.id')
            ->join('reports', 'reports.component_id', '=', 'components.id')
            ->join('roles', 'roles.id', '=', 'activities.role_id')
            ->selectRaw('
                    reports."month" as label,
                    sum(reports.realization_good
                        + reports.realization_social
                        + reports.realization_capital
                        + reports.realization_employee) as data
                ')
            ->groupBy('reports.month')
            ->orderBy('reports.month')
            ->when($year, fn($query) => $query->where('activities.year', $year))
            ->when(!empty($roles), fn($query) => $query->whereIn('roles.uuid', $roles))
            ->get();

        $realizationLabel = $realizations->map(fn($value, $key) => $value->label);
        $realizationData = $realizations->map(fn($value, $key) => $value->data);

        return [
            'datasets' => [
                [
                    'label' => 'Alokasi',
                    'data' => [
                        $allocationData,
                        $allocationData,
                        $allocationData,
                        $allocationData,
                        $allocationData,
                        $allocationData,
                        $allocationData,
                        $allocationData,
                        $allocationData,
                        $allocationData,
                        $allocationData,
                        $allocationData,
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
                    'data' => $realizationData,
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

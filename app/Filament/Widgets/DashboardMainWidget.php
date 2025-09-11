<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\Widget;

class DashboardMainWidget extends Widget
{
    use InteractsWithPageFilters;
    protected int | string | array $columnSpan = 12;
    protected string $view = 'filament.widgets.dashboard-main';
}

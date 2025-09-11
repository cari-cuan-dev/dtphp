<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\DashboardMainWidget;
use App\Models\Activity;
use App\Models\Role;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Support\Icons\Heroicon;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DashboardMain extends BaseDashboard
{
    use HasFiltersForm;

    protected static string $routePath = '/dashboard-main';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedHome;
    protected static ?string $slug = 'dasbor-main';

    // protected string $view = 'filament.pages.dashboard-main';

    public static function getNavigationLabel(): string
    {
        return __('Dashboard Main');
    }

    public function getHeaderWidgetsColumns(): int | array
    {
        return 12;
    }

    public function getWidgets(): array
    {
        return [
            // StatsWidget::class
            DashboardMainWidget::make()
        ];
    }

    public function filtersForm(Schema $schema): Schema
    {
        $roles = Role::whereNot('id', 1)->pluck('name');
        $activities = Activity::distinct('year')->pluck('year');
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        Select::make('role')
                            ->label(__('Role'))
                            ->searchable()
                            ->multiple()
                            ->options($roles)
                            ->columnSpan([
                                'default' => 12,
                                'sm' => 12,
                                'md' => 12,
                                'lg' => 6,
                                'xl' => 6,
                                '2xl' => 6,
                            ]),
                        Select::make('year')
                            ->label(__('Year'))
                            ->searchable()
                            ->options($activities)
                            ->columnSpan([
                                'default' => 12,
                                'sm' => 12,
                                'md' => 12,
                                'lg' => 6,
                                'xl' => 6,
                                '2xl' => 6,
                            ]),

                    ])
                    ->columns([
                        'default' => 12,
                        'sm' => 12,
                        'md' => 12,
                        'lg' => 12,
                        'xl' => 12,
                        '2xl' => 12,
                    ])
                    ->columnSpan([
                        'default' => 12
                    ]),
            ]);
    }
}

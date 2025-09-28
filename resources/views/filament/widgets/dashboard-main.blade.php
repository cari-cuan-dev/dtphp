<x-filament-widgets::widget>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <x-filament::section>
        <div class="space-y-6">
            <div class="grid grid-cols-12 gap-6">

                <div class="col-span-5">
                    @livewire(App\Filament\Widgets\DashboardMain\DepartmentDistributionWidget::class)
                </div>

                <div class="col-span-7 grid grid-cols-2">

                    <div class="col-span-2 xl:col-span-2">
                        @livewire(App\Filament\Widgets\DashboardMain\MonthlyFinancialWidget::class)
                    </div>

                    <div class="col-span-2 xl:col-span-2 mt-3">
                        @livewire(App\Filament\Widgets\DashboardMain\CumulativeFinancialWidget::class)
                    </div>

                </div>

            </div>
        </div>
    </x-filament::section>

</x-filament-widgets::widget>

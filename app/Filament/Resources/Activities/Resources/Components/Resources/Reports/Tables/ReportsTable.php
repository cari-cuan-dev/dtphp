<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Tables;

use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Classes\MutateData;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Facades\FilamentView;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Js;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        $component = $table->getLivewire()->ownerRecord;

        return $table
            ->columns([
                TextColumn::make('month')
                    ->label(__("Month"))
                    ->getStateUsing(
                        fn($record) => Carbon::createFromFormat('m', $record->month)->translatedFormat('F')
                    )
                    ->numeric()
                    ->sortable(),
                ColumnGroup::make('Status Pelaksanaan', [
                    TextColumn::make('implementation_category')
                        ->label('Kategori')
                        ->badge()
                        ->color(fn(string $state): string => match ($state) {
                            '' => 'gray',
                            'Perencanaan' => 'gray',
                            'Persiapan' => 'primary',
                            'Pelaksanaan' => 'info',
                            'Selesai' => 'success',
                        })
                        ->getStateUsing(fn($record) => ['', 'Perencanaan', 'Persiapan', 'Pelaksanaan', 'Selesai'][$record->implementation_category ?? 0]),
                    TextColumn::make('implementation_progress')
                        ->label('Kumulatif')
                        ->suffix('%')
                        ->alignEnd(),
                ]),
                ColumnGroup::make('Realisasi Fisik', [
                    TextColumn::make('physical_volume')
                        ->description(fn($record) => ' ' . $record->physical_unit)
                        // ->description(fn($record) => $record->physical_unit)
                        ->label('Komponen')
                        ->alignEnd(),
                    TextColumn::make('physical_real')
                        ->description(fn($record) => ' ' . $record->physical_real_unit)
                        ->label('Komponen Riil')
                        ->alignEnd(),
                ]),
                ColumnGroup::make('Realisasi Anggaran', [
                    TextColumn::make('Nominal')
                        ->label('Nominal')
                        ->getStateUsing(
                            fn($record) => $record->budget_realization()
                        )
                        ->numeric()
                        ->prefix('Rp ')
                        ->alignEnd(),
                    TextColumn::make('Parsial')
                        ->label('Parsial')
                        ->numeric()
                        ->getStateUsing(fn($record) => $record->budget_realization() / $table->getLivewire()->ownerRecord->allocation_total * 100)
                        ->suffix(' %')
                        ->alignEnd(),
                ]),
                ColumnGroup::make('Status', [
                    IconColumn::make('physical_status')
                        ->boolean()
                        ->label(__("Utilization"))
                        ->alignEnd(),
                    IconColumn::make('verified')
                        ->boolean()
                        ->label(__("Verfication"))
                        ->alignEnd(),
                ]),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn() => hexa()->can('report.update')),

                // Action::make('edit')
                //     ->label("Edit")
                //     ->accessSelectedRecords(false)
                //     ->alpineClickHandler(
                //         function ($record) {
                //             $url = route('filament.emonev.resources.activities.components.reports.edit', [
                //                 $record->component->activity->id,
                //                 $record->component->id,
                //                 $record->id
                //             ]);
                //             return FilamentView::hasSpaMode($url)
                //                 ? 'document.referrer ? window.history.back() : Livewire.navigate(' . Js::from($url) . ')'
                //                 : 'document.referrer ? window.history.back() : (window.location.href = ' . Js::from($url) . ')';
                //         }
                //     ),
                ViewAction::make()
                    ->visible(fn() => !hexa()->can('report.update') && hexa()->can('report.view')),
            ])
            ->recordAction('edit')
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                //     ForceDeleteBulkAction::make(),
                //     RestoreBulkAction::make(),
                // ]),
            ]);
    }
}

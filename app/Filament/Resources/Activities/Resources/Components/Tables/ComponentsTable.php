<?php

namespace App\Filament\Resources\Activities\Resources\Components\Tables;

use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class ComponentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('Code & Nomenclature'))
                    ->description(fn($record) => $record->label)
                    ->searchable(),
                TextColumn::make('volume')
                    ->label(__('Volume'))
                    ->description(fn($record) => $record->unit)
                    ->numeric()
                    ->sortable(),
                TextColumn::make(__('Implementation'))
                    ->state(fn($record) => $record->reports()->max('reports.implementation_progress'))
                    ->suffix('%')
                    ->numeric()
                    ->alignEnd(),
                ColumnGroup::make(__('Budget'), [
                    TextColumn::make('allocation')
                        ->label(__('Allocation'))
                        ->state(fn($record) => $record->allocation_total)
                        ->prefix('Rp ')
                        ->numeric()
                        ->alignEnd(),
                    TextColumn::make('realization')
                        ->label(__('Realization'))
                        ->state(
                            fn($record) => $record->reports()->sum(
                                DB::raw('realization_capital + realization_good + realization_employee + realization_social')
                            )
                        )
                        ->prefix('Rp ')
                        ->numeric()
                        ->alignEnd(),

                    TextColumn::make('persentase')
                        ->state(
                            function (Column $column) {
                                $columns = $column->getGroup()->getColumns();
                                if ($columns['allocation']->getState())
                                    return $columns['realization']->getState() / $columns['allocation']->getState() * 100;
                            }
                        )
                        ->numeric()
                        ->sortable()
                        ->alignEnd()
                        ->label('%')
                        ->suffix('%'),
                ]),

                ColumnGroup::make('Realisasi Anggaran Per Bulan', [
                    TextColumn::make('1')
                        ->label(Carbon::createFromFormat('m', 1)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 1)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('2')
                        ->label(Carbon::createFromFormat('m', 2)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 2)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('3')
                        ->label(Carbon::createFromFormat('m', 3)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 3)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('4')
                        ->label(Carbon::createFromFormat('m', 4)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 4)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('5')
                        ->label(Carbon::createFromFormat('m', 5)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 5)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('6')
                        ->label(Carbon::createFromFormat('m', 6)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 6)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('7')
                        ->label(Carbon::createFromFormat('m', 7)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 7)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('8')
                        ->label(Carbon::createFromFormat('m', 8)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 8)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('9')
                        ->label(Carbon::createFromFormat('m', 9)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 9)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('10')
                        ->label(Carbon::createFromFormat('m', 10)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 10)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('11')
                        ->label(Carbon::createFromFormat('m', 11)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 11)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                    TextColumn::make('12')
                        ->label(Carbon::createFromFormat('m', 12)->translatedFormat('F'))
                        ->state(fn($record) => $record->reports()->where('month', 12)->first()?->budget_realization() / $record->allocation_total * 100)
                        ->numeric()
                        ->suffix('%')
                        ->alignEnd(),
                ]),

                ColumnGroup::make('Auditable', [
                    TextColumn::make('created_by')
                        ->numeric()
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->sortable(),
                    TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('updated_by')
                        ->numeric()
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->sortable(),
                    TextColumn::make('updated_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                    TextColumn::make('deleted_by')
                        ->numeric()
                        ->toggleable(isToggledHiddenByDefault: true)
                        ->sortable(),
                    TextColumn::make('deleted_at')
                        ->dateTime()
                        ->sortable()
                        ->toggleable(isToggledHiddenByDefault: true),
                ]),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn() => hexa()->can('component.update')),
                ViewAction::make()
                    ->visible(fn() => !hexa()->can('component.update')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}

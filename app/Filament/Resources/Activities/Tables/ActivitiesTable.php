<?php

namespace App\Filament\Resources\Activities\Tables;

use App\Models\Activity;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                if (!hexa()->can('activity.index.all')) {
                    $roles = Auth::user()->roles()->pluck('roles.id')->toArray();
                    return $query->whereIn('role_id', $roles);
                }
                return $query;
            })
            ->columns([
                TextColumn::make('year')
                    ->label(__('Year'))
                    // ->numeric()
                    ->sortable()
                    // ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                TextColumn::make('role.name')
                    ->label(__('Role Name'))
                    ->sortable()
                    // ->toggleable(isToggledHiddenByDefault: false)
                    ->searchable(),
                TextColumn::make('code')
                    ->label(__('Code & Nomenclature'))
                    ->description(fn($record) => $record->label)
                    ->searchable(),
                TextColumn::make('volume')
                    ->label(__('Volume'))
                    ->description(fn($record) => $record->unit)
                    ->numeric()
                    ->alignEnd()
                    ->sortable(),
                TextColumn::make(__('Implementation'))
                    ->state(fn($record) => $record->reports()->max('reports.implementation_progress'))
                    ->suffix('%')
                    ->numeric()
                    ->alignEnd(),
                ColumnGroup::make(__('Budget'), [
                    TextColumn::make('allocation')
                        ->label(__('Allocation'))
                        ->state(fn($record) => $record->components()->sum('allocation_total'))
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
                // TextColumn::make('unit')
                //     ->label(__('Unit'))
                //     ->searchable(),
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
            ->groups([
                // Group::make('year')
                //     ->label(__("Year"))
                //     ->getKeyFromRecordUsing(fn(): string => 'abc')
                //     ->getTitleFromRecordUsing(fn(Model $record): string =>  $record->year . ' | ' . __('Role') . ': ' . $record->role->name),
            ])
            // ->defaultGroup('year')
            // ->groupingSettingsHidden()
            ->recordActions([
                EditAction::make()
                    ->visible(fn() => hexa()->can('activity.update')),
                ViewAction::make()
                    ->visible(fn() => !hexa()->can('activity.update')),
            ]);
    }
}

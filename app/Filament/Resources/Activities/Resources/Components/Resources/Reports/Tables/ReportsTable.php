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
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

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
                        // ->getStateUsing(fn($record) => $record ? __("Sudah dimanfaatkan") : __("Belum dimanfaatkan"))
                        ->label(__("Utilization"))
                        ->alignEnd(),
                    IconColumn::make('verified')
                        ->boolean()
                        // ->getStateUsing(fn($record) => $record ? __("Sudah dimanfaatkan") : __("Belum dimanfaatkan"))
                        ->label(__("Verfication"))
                        ->alignEnd(),
                ]),
                // TextColumn::make('physical_status')
                //     ->getStateUsing(fn($record) => $record ? __("Sudah dimanfaatkan") : __("Belum dimanfaatkan"))
                //     ->label(__("Status Pemanfaatan"))
                //     ->alignEnd(),
                IconColumn::make('physical_status')
                    ->boolean()
                    // ->getStateUsing(fn($record) => $record ? __("Sudah dimanfaatkan") : __("Belum dimanfaatkan"))
                    ->label(__("Status Pemanfaatan"))
                    ->alignEnd(),
                // TextColumn::make('physical_volume')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('physical_unit')
                //     ->searchable(),
                // TextColumn::make('physical_real')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('physical_real_unit')
                //     ->searchable(),
                // TextColumn::make('physical_category')
                //     ->searchable(),
                // IconColumn::make('physical_status')
                //     ->boolean(),
                // TextColumn::make('realization_capital')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('realization_good')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('realization_employee')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('realization_social')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('implementation_progress')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('implementation_category')
                //     ->numeric()
                //     ->sortable(),
                // IconColumn::make('issue_solved')
                //     ->boolean(),
                // TextColumn::make('support_document_path')
                //     ->searchable(),
                // TextColumn::make('support_photo_path')
                //     ->searchable(),
                // TextColumn::make('support_video_path')
                //     ->searchable(),
                // IconColumn::make('verified')
                //     ->boolean(),
                // TextColumn::make('verified_at')
                //     ->dateTime()
                //     ->sortable(),
                // TextColumn::make('verified_by')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('deleted_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // TextColumn::make('created_by')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('updated_by')
                //     ->numeric()
                //     ->sortable(),
                // TextColumn::make('deleted_by')
                //     ->numeric()
                //     ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                // EditAction::make()
                //     ->visible(fn() => hexa()->can('report.update')),
                Action::make('Edit')
                    ->url(function ($record) {
                        return route('filament.emonev.resources.activities.components.reports.edit', [
                            $record->component->activity->id,
                            $record->component->id,
                            $record->id
                        ]);
                    }),

                ViewAction::make()
                    ->visible(fn() => !hexa()->can('report.update')),
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

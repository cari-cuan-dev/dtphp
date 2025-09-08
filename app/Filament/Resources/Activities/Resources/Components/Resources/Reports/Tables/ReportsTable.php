<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ReportsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('month')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('physical_volume')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('physical_unit')
                    ->searchable(),
                TextColumn::make('physical_real')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('physical_real_unit')
                    ->searchable(),
                TextColumn::make('physical_category')
                    ->searchable(),
                IconColumn::make('physical_status')
                    ->boolean(),
                TextColumn::make('realization_capital')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('realization_good')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('realization_employee')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('realization_social')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('implementation_progress')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('implementation_category')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('issue_solved')
                    ->boolean(),
                TextColumn::make('support_document_path')
                    ->searchable(),
                TextColumn::make('support_photo_path')
                    ->searchable(),
                TextColumn::make('support_video_path')
                    ->searchable(),
                IconColumn::make('verified')
                    ->boolean(),
                TextColumn::make('verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('verified_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('updated_by')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('deleted_by')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
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

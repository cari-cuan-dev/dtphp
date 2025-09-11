<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Pages;

use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\ReportResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn() => hexa()->can('report.create')),
            DeleteAction::make()
                ->visible(fn() => hexa()->can('report.delete')),
            ForceDeleteAction::make()
                ->visible(fn() => hexa()->can('report.delete.force')),
            RestoreAction::make()
                ->visible(fn() => hexa()->can('report.restore')),
        ];
    }
}

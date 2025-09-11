<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Pages;

use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\ReportResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditReport extends EditRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn() => hexa()->can('report.delete')),
            ForceDeleteAction::make()
                ->visible(fn() => hexa()->can('report.delete.force')),
            RestoreAction::make()
                ->visible(fn() => hexa()->can('report.restore')),
        ];
    }
}

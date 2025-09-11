<?php

namespace App\Filament\Resources\Activities\Pages;

use App\Filament\Resources\Activities\ActivityResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

class ViewActivity extends ViewRecord
{
    protected static string $resource = ActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn() => hexa()->can('activity.create')),
            DeleteAction::make()
                ->visible(fn() => hexa()->can('activity.delete')),
            ForceDeleteAction::make()
                ->visible(fn() => hexa()->can('activity.delete.force')),
            RestoreAction::make()
                ->visible(fn() => hexa()->can('activity.restore')),
        ];
    }
}

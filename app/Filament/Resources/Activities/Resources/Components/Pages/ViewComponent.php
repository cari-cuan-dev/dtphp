<?php

namespace App\Filament\Resources\Activities\Resources\Components\Pages;

use App\Filament\Resources\Activities\Resources\Components\ComponentResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\ViewRecord;

class ViewComponent extends ViewRecord
{
    protected static string $resource = ComponentResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(hexa()->can('component.view'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->visible(fn() => hexa()->can('component.create')),
            DeleteAction::make()
                ->visible(fn() => hexa()->can('component.delete')),
            ForceDeleteAction::make()
                ->visible(fn() => hexa()->can('component.delete.force')),
            RestoreAction::make()
                ->visible(fn() => hexa()->can('component.restore')),
        ];
    }
}

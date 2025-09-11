<?php

namespace App\Filament\Resources\Activities\Resources\Components\Pages;

use App\Filament\Resources\Activities\Resources\Components\ComponentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditComponent extends EditRecord
{
    protected static string $resource = ComponentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn() => hexa()->can('component.delete')),
            ForceDeleteAction::make()
                ->visible(fn() => hexa()->can('component.delete.force')),
            RestoreAction::make()
                ->visible(fn() => hexa()->can('component.restore')),
        ];
    }
}

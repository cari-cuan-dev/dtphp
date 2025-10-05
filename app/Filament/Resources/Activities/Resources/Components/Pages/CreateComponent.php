<?php

namespace App\Filament\Resources\Activities\Resources\Components\Pages;

use App\Filament\Resources\Activities\Resources\Components\ComponentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateComponent extends CreateRecord
{
    protected static string $resource = ComponentResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(hexa()->can('component.create'), 403);
    }
}

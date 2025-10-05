<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Pages;

use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\ReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(hexa()->can('report.create'), 403);
    }
}

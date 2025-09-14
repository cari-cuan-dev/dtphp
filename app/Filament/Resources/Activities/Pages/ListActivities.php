<?php

namespace App\Filament\Resources\Activities\Pages;

use App\Filament\Exports\ActivityExporter;
use App\Filament\Resources\Activities\ActivityResource;
use App\Models\Activity;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Spatie\LaravelPdf\Enums\Orientation;

use function Spatie\LaravelPdf\Support\pdf;

class ListActivities extends ListRecords
{
    protected static string $resource = ActivityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ExportAction::make(),
            // Action::make('export')
            //     ->schema([
            //         Select::make('code')
            //             ->options(
            //                 ['all' => 'All']
            //                     + Activity::pluck('code', 'id')->toArray()
            //             )->multiple()
            //             // ->options([
            //             //     'pdf' => 'PDF',
            //             //     'xlsx' => 'XLSX',
            //             //     'csv' => 'CSV',
            //             // ])
            //             ->default('pdf')
            //             ->required(),
            //     ])
            // ->action(function () {
            //     return pdf()->view('export.activity')
            //         ->landscape()
            //         ->margins(
            //             top: 10,
            //             right: 10,
            //             bottom: 10,
            //             left: 10,
            //             unit: 'mm'
            //         )
            //         ->paperSize(210, 297, 'mm')
            //         ->base64();
            // }),
            // ,
            CreateAction::make()
                ->visible(fn() => hexa()->can('activity.create')),
        ];
    }
}

<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports\RelationManagers;

use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\ReportResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ReportsRelationManager extends RelationManager
{
    protected static string $relationship = 'reports';

    protected static ?string $relatedResource = ReportResource::class;

    public function table(Table $table): Table
    {
        $component = $table->getLivewire()->ownerRecord;

        return $table
            ->headerActions([
                Action::make('Create')
                    ->url(route('filament.emonev.resources.activities.components.reports.create', [
                        $component->activity->id,
                        $component->id
                    ]))
                    ->visible(fn() => hexa()->can('report.create')),
                CreateAction::make()
                    ->visible(fn() => hexa()->can('report.create')),
                // ->mutateDataUsing(function (array $data): array {
                //     return MutateData::before_creation($data);
                // })
            ]);
    }

    protected function canCreate(): bool
    {
        return true;
    }

    protected function canEdit(Model $record): bool
    {
        return true;
    }
}

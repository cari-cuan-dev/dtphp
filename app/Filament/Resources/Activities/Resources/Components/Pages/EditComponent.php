<?php

namespace App\Filament\Resources\Activities\Resources\Components\Pages;

use App\Filament\Resources\Activities\Resources\Components\ComponentResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Js;

class EditComponent extends EditRecord
{
    protected static string $resource = ComponentResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(hexa()->can('component.edit'), 403);
    }

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

    protected function getCancelFormAction(): Action
    {
        $url = route('filament.emonev.resources.activities.edit', [
            'record' => $this->parentRecord->id
        ]);

        return Action::make('cancel')
            ->label(__('Back'))
            ->alpineClickHandler(
                FilamentView::hasSpaMode($url)
                    ? 'document.referrer ? window.history.back() : Livewire.navigate(' . Js::from($url) . ')'
                    : 'document.referrer ? window.history.back() : (window.location.href = ' . Js::from($url) . ')',
            )
            ->color('gray');
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCancelFormAction(),
            $this->getSaveFormAction(),
        ];
    }
}

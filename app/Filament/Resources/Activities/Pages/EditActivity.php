<?php

namespace App\Filament\Resources\Activities\Pages;

use App\Filament\Resources\Activities\ActivityResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Js;

class EditActivity extends EditRecord
{
    protected static string $resource = ActivityResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(hexa()->can('activity.update'), 403);
    }

    protected function getHeaderActions(): array
    {
        return [
            $this->getCancelFormAction(),

            DeleteAction::make()
                ->visible(fn() => hexa()->can('activity.delete')),
            ForceDeleteAction::make()
                ->visible(fn() => hexa()->can('activity.delete.force')),
            RestoreAction::make()
                ->visible(fn() => hexa()->can('activity.restore')),
        ];
    }

    protected function getCancelFormAction(): Action
    {
        $url = route('filament.emonev.resources.activities.index');

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

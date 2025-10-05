<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function authorizeAccess(): void
    {
        abort_unless(hexa()->can('user.update'), 403);
    }
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->visible(fn() => hexa()->can('user.delete')),
        ];
    }
}

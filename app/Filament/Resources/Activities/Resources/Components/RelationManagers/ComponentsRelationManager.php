<?php

namespace App\Filament\Resources\Activities\Resources\Components\RelationManagers;

use App\Filament\Resources\Activities\Resources\Components\ComponentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ComponentsRelationManager extends RelationManager
{
    protected static string $relationship = 'components';

    protected static ?string $relatedResource = ComponentResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make()
                    ->visible(fn() => hexa()->can('component.create')),
            ]);
    }

    protected function canEdit(Model $record): bool
    {
        return true;
    }
}

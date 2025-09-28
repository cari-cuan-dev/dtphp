<?php

namespace App\Filament\Resources\Departments\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\GridDirection;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        $permissions = collect(config('hexa-lite-roles'))
            ->map(function ($role) {
                $key = \Illuminate\Support\Str::slug($role['name'], '_');
                return Section::make($role['name'])
                    ->collapsed(false)
                    ->schema([
                        CheckboxList::make("gates.{$key}")
                            ->searchable()
                            ->columns(2)
                            ->gridDirection(GridDirection::Row)
                            ->hiddenLabel()
                            ->bulkToggleable()
                            ->options($role['names']),
                    ]);
            });

        return $schema
            ->columns(1)
            ->components([
                TextInput::make('name')
                    ->label(__('Role Name'))
                    ->maxLength(100)
                    ->placeholder(__('Supervisor'))
                    ->required(),
                TextInput::make('description')
                    ->label(__('Description'))
                    ->maxLength(100),
                // ViewField::make('checkall')
                //     ->label(__('Check / Uncheck all'))
                //     ->view('hexa::role.toggle-button'),
                ...$permissions,
            ]);
    }
}

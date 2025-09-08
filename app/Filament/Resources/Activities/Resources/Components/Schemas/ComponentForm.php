<?php

namespace App\Filament\Resources\Activities\Resources\Components\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ComponentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->required(),
                TextInput::make('label')
                    ->required(),
                TextInput::make('volume')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('unit')
                    ->required(),
                TextInput::make('allocation_total')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('allocation_capital')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('allocation_good')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('allocation_employee')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('allocation_social')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('description')
                    ->columnSpanFull(),
            ]);
    }
}

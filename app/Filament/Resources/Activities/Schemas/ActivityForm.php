<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('role_id')
                    ->label(__('Role'))
                    ->relationship('role', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('year')
                    ->label(__('Year'))
                    ->required()
                    ->numeric(),
                Grid::make()
                    ->columns([
                        'xs' => 12,
                        'sm' => 12,
                        'md' => 12,
                        'xl' => 12,
                    ])
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('code')
                            ->label(__('Code'))
                            ->required()
                            ->columnSpan([
                                'xs' => 12,
                                'sm' => 6,
                                'md' => 4,
                                'xl' => 4,
                            ]),
                        TextInput::make('label')
                            ->label(__('Label'))
                            ->required()
                            ->columnSpan([
                                'xs' => 12,
                                'sm' => 6,
                                'md' => 4,
                                'xl' => 4,
                            ]),
                        TextInput::make('volume')
                            ->label(__('Volume'))
                            ->required()
                            ->numeric()
                            ->columnSpan([
                                'xs' => 12,
                                'sm' => 8,
                                'md' => 3,
                                'xl' => 3
                            ]),
                        TextInput::make('unit')
                            ->label(__('Unit'))
                            ->required()
                            ->columnSpan([
                                'xs' => 12,
                                'sm' => 4,
                                'md' => 1,
                                'xl' => 1
                            ]),
                    ])
            ]);
    }
}

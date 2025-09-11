<?php

namespace App\Filament\Resources\Activities\Resources\Components\Schemas;

use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\ReportResource;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class ComponentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('activity_id')
                    ->formatStateUsing(fn($livewire) => $livewire->getParentRecord()->code)
                    ->disabled()
                    ->columnSpanFull()
                    ->label(__('Activity')),
                TextInput::make('code')
                    ->label(__('Code'))
                    ->required(),
                TextInput::make('label')
                    ->label(__('Label'))
                    ->required(),

                Section::make('Fisik & Anggaran')
                    ->columnSpanFull()
                    ->columns(12)
                    ->schema([
                        TextInput::make('volume')
                            ->label(__('Volume'))
                            ->required()
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->default(0)
                            ->columnSpan(4)
                            ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                            ->placeholder(0)
                            ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),
                        TextInput::make('unit')
                            ->label(__('Unit'))
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('allocation_total')
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->prefix('Rp')
                            ->readOnly()
                            ->disabled()
                            ->dehydrated(true)
                            ->required()
                            ->default(0)
                            ->columnSpan(6)
                            ->mutateDehydratedStateUsing(fn(Get $get) => $get('allocation_capital') + $get('allocation_good') + $get('allocation_employee') + $get('allocation_social')),
                    ]),
                Section::make('Alokasi Anggaran per Jenis Belanja')
                    ->columnSpanFull()
                    ->columns([
                        'default' => 4,
                        'sm' => 4,
                        'md' => 4,
                        'lg' => 4,
                        'xl' => 4,
                        '2xl' => 4,
                    ])
                    ->schema([
                        TextInput::make('allocation_capital')
                            ->label(__('Allocation Capital'))
                            ->required()
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->prefix('Rp')
                            ->default(0)
                            ->columnSpan([
                                'default' => 4,
                                'sm' => 4,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 1,
                                '2xl' => 1,
                            ])
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                static::UpdateAllocationTotal($set, $get);
                            })
                            ->live(debounce: 2000)
                            ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                            ->placeholder(0)
                            ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),

                        TextInput::make('allocation_good')
                            ->label(__('Allocation Good'))
                            ->required()
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->prefix('Rp')
                            ->default(0)
                            ->columnSpan([
                                'default' => 4,
                                'sm' => 4,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 1,
                                '2xl' => 1,
                            ])
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                static::UpdateAllocationTotal($set, $get);
                            })
                            ->live(debounce: 2000)
                            ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                            ->placeholder(0)
                            ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),

                        TextInput::make('allocation_employee')
                            ->label(__('Allocation Employee'))
                            ->required()
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->prefix('Rp')
                            ->default(0)
                            ->columnSpan([
                                'default' => 4,
                                'sm' => 4,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 1,
                                '2xl' => 1,
                            ])
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                static::UpdateAllocationTotal($set, $get);
                            })
                            ->live(debounce: 2000)
                            ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                            ->placeholder(0)
                            ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),

                        TextInput::make('allocation_social')
                            ->label(__('Allocation Social'))
                            ->required()
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->prefix('Rp')
                            ->default(0)
                            ->columnSpan([
                                'default' => 4,
                                'sm' => 4,
                                'md' => 2,
                                'lg' => 2,
                                'xl' => 1,
                                '2xl' => 1,
                            ])
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                static::UpdateAllocationTotal($set, $get);
                            })
                            ->live(debounce: 2000)
                            ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                            ->placeholder(0)
                            ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),
                    ]),
                Section::make(__("Other"))
                    ->columnSpanFull()
                    ->collapsed()
                    ->schema([
                        Textarea::make('description')
                            ->label(__('Description'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
                Section::make(__("Reports"))
                    ->columnSpanFull()
                    ->collapsed()
                    ->visibleOn('create')
                    ->schema([
                        Repeater::make('reports')
                            ->label(__("Montly"))
                            ->relationship()
                            ->columnSpanFull()
                            ->minItems(0)
                            ->defaultItems(0)
                            ->required(false)
                            ->schema(
                                ReportResource::form($schema)->getComponents()
                            )
                    ])
            ]);
    }

    protected static function UpdateAllocationTotal(Set $set, Get $get): void
    {
        $set(
            'allocation_total',
            $get('allocation_capital')
                + $get('allocation_good')
                + $get('allocation_employee')
                + $get('allocation_social')
        );
    }
}

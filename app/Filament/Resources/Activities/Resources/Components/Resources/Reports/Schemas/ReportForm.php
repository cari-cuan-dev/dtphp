<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Schemas;

use Carbon\Carbon;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

use function PHPSTORM_META\map;
use function Psy\debug;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('activity.code')
                    ->formatStateUsing(fn($livewire) => $livewire->getParentRecord()->activity?->code)
                    ->hidden(function ($livewire) {
                        return $livewire->getName() == 'app.filament.resources.activities.resources.components.pages.create-component';
                    })
                    ->label(__('Activity'))
                    ->disabled(),
                TextInput::make('component.id')
                    ->formatStateUsing(fn($livewire) => $livewire->getParentRecord()->code)
                    ->hidden(function ($livewire) {
                        return $livewire->getName() == 'app.filament.resources.activities.resources.components.pages.create-component';
                    })
                    ->label(__('Component'))
                    ->disabled(),
                Select::make('month')
                    ->columnSpanFull()
                    ->label(__("Month"))
                    ->options(collect(array_slice(range(0, 12), 1, 12, true))->map(fn($item) => Carbon::createFromFormat('m', $item)->translatedFormat('F')))
                    ->required()
                    ->disabledOn('edit'),
                Section::make(__("Fisik"))
                    ->columnSpanFull()
                    ->columns([
                        "default" => 12,
                        "sm" => 12,
                        "md" => 12,
                        "lg" => 12,
                        "xl" => 12,
                    ])
                    ->schema([
                        Grid::make()
                            ->columnSpan([
                                "default" => 12,
                                "sm" => 12,
                                "md" => 4,
                                "lg" => 4,
                                "xl" => 4,
                            ])
                            ->columns([
                                "default" => 12,
                                "sm" => 12,
                                "md" => 12,
                                "lg" => 12,
                                "xl" => 12,
                            ])
                            ->schema([
                                TextInput::make('physical_volume')
                                    ->label(__('Volume'))
                                    ->belowLabel(__("Realisasi Fisik"))
                                    ->required()
                                    ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                                    ->default(0)
                                    ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                                    ->placeholder(0)
                                    ->columnSpan([
                                        "default" => 12,
                                        "sm" => 12,
                                        "md" => 12,
                                        "lg" => 12,
                                        "xl" => 12,
                                    ])
                                    ->suffix('%')
                                    ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),
                                TextInput::make('physical_real')
                                    ->label(__('Volume'))
                                    ->belowLabel(__("Realisasi Riil"))
                                    ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                                    ->default(0)
                                    ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                                    ->placeholder(0)
                                    ->suffix('%')
                                    ->columnSpan([
                                        "default" => 12,
                                        "sm" => 12,
                                        "md" => 12,
                                        "lg" => 12,
                                        "xl" => 12,
                                    ]),
                            ]),
                        Grid::make()
                            ->columnSpan([
                                "default" => 12,
                                "sm" => 12,
                                "md" => 8,
                                "lg" => 8,
                                "xl" => 8,
                            ])
                            ->schema([
                                Select::make('physical_category')
                                    ->label(__("Jenis"))
                                    ->belowLabel(__("Komponen"))
                                    ->options([
                                        "main" => __("Utama"),
                                        "secondary" => __("Pendukung"),
                                    ])
                                    ->required()
                                    ->default('secondary')
                                    ->columnSpanFull(),
                                Select::make('physical_status')
                                    ->label(__("Status"))
                                    ->belowLabel(__("Kemanfaatan"))
                                    ->options([
                                        false => __("Belum dimanfaatkan"),
                                        true => __("Sudah dimanfaatkan"),
                                    ])
                                    ->searchable()
                                    ->required()
                                    ->columnSpanFull(),
                            ]),
                    ]),
                Section::make(__("Realisasi Anggaran ( SPM )"))
                    ->columnSpanFull()
                    ->columns([
                        "default" => 12,
                        "sm" => 12,
                        "md" => 12,
                        "lg" => 12,
                        "xl" => 12,
                    ])
                    ->schema([
                        TextInput::make('realization_capital')
                            // ->required()
                            ->label(__("Belanja Modal"))
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->prefix('Rp')
                            ->default(0)
                            ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                            ->placeholder(0)
                            ->columnSpan([
                                "default" => 6,
                                "sm" => 6,
                                "md" => 6,
                                "lg" => 6,
                                "xl" => 3,
                            ])
                            ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),
                        TextInput::make('realization_good')
                            // ->required()
                            ->label(__("Belanja Barang"))
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->prefix('Rp')
                            ->default(0)
                            ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                            ->placeholder(0)
                            ->columnSpan([
                                "default" => 6,
                                "sm" => 6,
                                "md" => 6,
                                "lg" => 6,
                                "xl" => 3,
                            ])
                            ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),
                        TextInput::make('realization_employee')
                            // ->required()
                            ->label(__("Belanja Pegawai"))
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->prefix('Rp')
                            ->default(0)
                            ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                            ->placeholder(0)
                            ->columnSpan([
                                "default" => 6,
                                "sm" => 6,
                                "md" => 6,
                                "lg" => 6,
                                "xl" => 3,
                            ])
                            ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),
                        TextInput::make('realization_social')
                            // ->required()
                            ->label(__("Belanja Sosial"))
                            ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                            ->prefix('Rp')
                            ->default(0)
                            ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                            ->placeholder(0)
                            ->columnSpan([
                                "default" => 6,
                                "sm" => 6,
                                "md" => 6,
                                "lg" => 6,
                                "xl" => 3,
                            ])
                            ->mutateDehydratedStateUsing(fn($state) => $state == null ? 0 : $state),
                    ]),
                Section::make(__("Pelaksanaan"))
                    ->columnSpanFull()
                    ->columns([
                        "default" => 12,
                        "sm" => 12,
                        "md" => 12,
                        "lg" => 12,
                        "xl" => 12,
                    ])
                    ->schema([
                        Grid::make()
                            ->columnSpan([
                                "default" => 12,
                                "sm" => 4,
                                "md" => 4,
                                "lg" => 4,
                                "xl" => 4,
                            ])
                            ->schema([
                                TextInput::make('implementation_progress')
                                    ->required()
                                    ->currencyMask(thousandSeparator: '.', decimalSeparator: ',', precision: 0)
                                    ->suffix('%')
                                    ->columnSpanFull()
                                    ->default(0)
                                    ->live()
                                    ->afterStateHydrated(fn($state, TextInput $component) => $component->state($state == 0 ? null : $state))
                                    ->placeholder(0)
                                    ->afterStateUpdated(function ($state, Set $set) {
                                        if ($state) {
                                            $set('implementation_category', $state < 11 ? 1 : ($state < 26 ? 2 : ($state < 100 ? 3 : 4)));
                                        }
                                    }),
                                Select::make('implementation_category')
                                    ->options([
                                        1 => 'A. Perencanaan (0 <= Progress < 11%)',
                                        2 => 'B. Persiapan (11% <= Progress < 26%)',
                                        3 => 'C. Pelaksanaan (26% <= Progress < 100%)',
                                        4 => 'D. Selesai (100%)',
                                    ])
                                    ->required()
                                    ->default(1)
                                    ->disabled()
                                    ->dehydrated(true)
                                    ->columnSpanFull()
                                    ->live(),
                            ]),
                        Grid::make()
                            ->columnSpan([
                                "default" => 12,
                                "sm" => 8,
                                "md" => 8,
                                "lg" => 8,
                                "xl" => 8,
                            ])
                            ->schema([
                                Textarea::make('implementation_description')
                                    ->columnSpanFull()
                                    ->rows(4)
                            ])

                    ]),
                Section::make(__("Permasalahan"))
                    ->columnSpanFull()
                    ->columns([
                        "default" => 12,
                        "sm" => 12,
                        "md" => 12,
                        "lg" => 12,
                        "xl" => 12,
                    ])
                    ->schema([
                        Select::make('issue_solved')
                            ->options([
                                true => __("Sudah Selesai"),
                                false => __("Belum Selesai")
                            ])
                            ->required()
                            ->columnSpan([
                                "default" => 12,
                                "sm" => 4,
                                "md" => 4,
                                "lg" => 4,
                                "xl" => 4,
                            ]),
                        Textarea::make('issue_description')
                            ->columnSpan([
                                "default" => 12,
                                "sm" => 8,
                                "md" => 8,
                                "lg" => 8,
                                "xl" => 8,
                            ]),
                    ]),
                Section::make(__("Bukti Dukung"))
                    ->columnSpanFull()
                    ->columns(12)
                    ->schema([
                        FileUpload::make('support_document_path')
                            ->columnSpan(4),
                        FileUpload::make('support_photo_path')
                            ->columnSpan(4),
                        FileUpload::make('support_video_path')
                            ->columnSpan(4),
                    ]),
                Section::make(__("Verifikasi"))
                    ->columnSpanFull()
                    ->visible(true)
                    ->columns(12)
                    ->hidden(function ($livewire) {
                        return $livewire->getName() == 'app.filament.resources.activities.resources.components.pages.create-component';
                    })
                    ->schema([
                        Select::make('verified')
                            ->options([
                                false => 'Data belum diverifikasi',
                                true => 'Data sudah diverifikasi',
                            ])
                            ->searchable()
                            ->columnSpan(4)
                            ->required()
                            ->default(false)
                            ->disabled(!hexa()->can('report.verify')),
                        // DateTimePicker::make('verified_at'),
                        // TextInput::make('verified_by')
                        //     ->numeric(),
                        Textarea::make('verified_notes')
                            ->columnSpan(8)
                            ->disabled(!hexa()->can('report.verify')),
                    ])
            ]);
    }
}

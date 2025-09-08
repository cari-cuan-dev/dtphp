<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('month')
                    ->required()
                    ->numeric(),
                TextInput::make('physical_volume')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('physical_unit')
                    ->required(),
                TextInput::make('physical_real')
                    ->numeric(),
                TextInput::make('physical_real_unit'),
                TextInput::make('physical_category')
                    ->required()
                    ->default('secondary'),
                Toggle::make('physical_status')
                    ->required(),
                TextInput::make('realization_capital')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('realization_good')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('realization_employee')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('realization_social')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('implementation_progress')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('implementation_category')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('implementation_description')
                    ->columnSpanFull(),
                Toggle::make('issue_solved')
                    ->required(),
                Textarea::make('issue_description')
                    ->columnSpanFull(),
                TextInput::make('support_document_path'),
                TextInput::make('support_photo_path'),
                TextInput::make('support_video_path'),
                Toggle::make('verified')
                    ->required(),
                DateTimePicker::make('verified_at'),
                TextInput::make('verified_by')
                    ->numeric(),
                Textarea::make('verified_notes')
                    ->columnSpanFull(),
            ]);
    }
}

<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports;

use App\Filament\Resources\Activities\Resources\Components\ComponentResource;
use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Pages\CreateReport;
use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Pages\EditReport;
use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Pages\ViewReport;
use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\RelationManagers\ReportAuditsRelationManager;
use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\RelationManagers\ReportsRelationManager;
use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Schemas\ReportForm;
use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Tables\ReportsTable;
use App\Models\Report;
use BackedEnum;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Hexters\HexaLite\HasHexaLite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReportResource extends Resource
{
    use HasHexaLite;

    protected static ?string $model = Report::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ComponentResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('Reports');
    }
    public function roleName()
    {
        return __('Reports');
    }

    public static function canAccess(): bool
    {
        return hexa()->can('report.index');
    }

    public function defineGates(): array
    {
        return [
            'report.index' => __('View data'),
            'report.create' => __('Creating data'),
            'report.update' => __('Updating data'),
            'report.delete' => __('Deleting data'),
            'report.delete.force' => __('Deleting data (Force)'),
            'report.view' => __('View spesific data'),
            'report.restore' => __('Restore data deleted'),
            'report.audit.index' => __('View audit data'),
            'report.audit.restore' => __('Resotre audit data'),
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return ReportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReportsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make(__('Changelog'), [
                'Audit' => ReportAuditsRelationManager::make(),
            ])
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateReport::route('/create'),
            'edit' => EditReport::route('/{record}/edit'),
            'view' => ViewReport::route('/{record}/view'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

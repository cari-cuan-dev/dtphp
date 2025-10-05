<?php

namespace App\Filament\Resources\Activities;

use App\Filament\Resources\Activities\Pages\CreateActivity;
use App\Filament\Resources\Activities\Pages\EditActivity;
use App\Filament\Resources\Activities\Pages\ListActivities;
use App\Filament\Resources\Activities\Pages\ViewActivity;
use App\Filament\Resources\Activities\Resources\Components\RelationManagers\ComponentsRelationManager;
use App\Filament\Resources\Activities\Schemas\ActivityForm;
use App\Filament\Resources\Activities\Tables\ActivitiesTable;
use App\Models\Activity;
use BackedEnum;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Hexters\HexaLite\HasHexaLite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
// use Tapp\FilamentAuditing\RelationManagers\ActivityAuditsRelationManager;
use App\Filament\Resources\Activities\RelationManagers\ActivityAuditsRelationManager;
use Filament\Actions\Action;

class ActivityResource extends Resource
{
    use HasHexaLite;

    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function getModelLabel(): string
    {
        return __('Activity');
    }

    public function roleName()
    {
        return __('Activity');
    }

    public static function canAccess(): bool
    {
        return hexa()->can('activity.index');
    }

    public function defineGates(): array
    {
        return [
            'activity.index' => __('View data'),
            'activity.index.all' => __('View data from all department'),
            'activity.create' => __('Creating data'),
            'activity.update' => __('Updating data'),
            'activity.delete' => __('Deleting data'),
            'activity.delete.force' => __('Deleting data (Force)'),
            'activity.view' => __('View spesific data'),
            'activity.export' => __('Export spesific data'),
            'activity.restore' => __('Restore data deleted'),
            'activity.audit.index' => __('View audit data'),
            'activity.audit.restore' => __('Resotre audit data'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('Activity Menu');
    }

    public static function form(Schema $schema): Schema
    {
        return ActivityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivitiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make(__('Components'), [
                'components' => ComponentsRelationManager::make(),
            ]),
            RelationGroup::make(__('Changelog'), [
                'Audit' => ActivityAuditsRelationManager::make(['view' => true]),
            ])
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivities::route('/'),
            'create' => CreateActivity::route('/create'),
            'edit' => EditActivity::route('/{record}/edit'),
            'view' => ViewActivity::route('/{record}/view'),
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

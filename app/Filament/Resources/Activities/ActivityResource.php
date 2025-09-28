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
            'activity.index' => __('Allows viewing the activity list according to role'),
            'activity.index.all' => __('Allows viewing all the activity list'),
            'activity.create' => __('Allows creating a new activity'),
            'activity.update' => __('Allows updating activities'),
            'activity.view' => __('Allows view activity'),
            'activity.delete' => __('Allows deleting activities'),
            'activity.delete.force' => __('Allows deleteing activities (Force)'),
            'activity.restore' => __('Allows restore activities'),
            'activity.audit.index' => __('Allows view audit activities'),
            'activity.audit.restore' => __('Allows resotre audit activities')
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

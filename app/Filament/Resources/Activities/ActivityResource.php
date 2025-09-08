<?php

namespace App\Filament\Resources\Activities;

use App\Filament\Resources\Activities\Pages\CreateActivity;
use App\Filament\Resources\Activities\Pages\EditActivity;
use App\Filament\Resources\Activities\Pages\ListActivities;
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
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class ActivityResource extends Resource
{
    use HasHexaLite;

    protected static ?string $model = Activity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

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
            'activity.index' => __('Allows viewing the activity list'),
            'activity.create' => __('Allows creating a new activity'),
            'activity.update' => __('Allows updating activities'),
            'activity.delete' => __('Allows deleting activities'),
            'activity.delete.force' => __('Allows deleteing activities (Force)'),
            'activity.restore' => __('Allows restore activities'),
            'activity.audit' => __('Allows view Audit activities')
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
        // $data = [RelationGroup::make(__('Components'), [
        //     'components' => ComponentsRelationManager::make(),
        // ])];

        // if (hexa()->can(['activity.audit']))
        //     array_push(
        //         $data,
        //         RelationGroup::make(__('Changelog'), [
        //             'Audit2' => AuditsRelationManager::make(),
        //         ])
        //     );

        $data = [
            RelationGroup::make(__('Components'), [
                'components' => ComponentsRelationManager::make(),
            ]),
            RelationGroup::make(__('Changelog'), [
                'Audit' => AuditsRelationManager::make(),
            ])
        ];
        return $data;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivities::route('/'),
            'create' => CreateActivity::route('/create'),
            'edit' => EditActivity::route('/{record}/edit'),
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

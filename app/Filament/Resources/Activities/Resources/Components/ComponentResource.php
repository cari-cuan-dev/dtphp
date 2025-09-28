<?php

namespace App\Filament\Resources\Activities\Resources\Components;

use App\Filament\Resources\Activities\ActivityResource;
use App\Filament\Resources\Activities\Resources\Components\Pages\CreateComponent;
use App\Filament\Resources\Activities\Resources\Components\Pages\EditComponent;
use App\Filament\Resources\Activities\Resources\Components\Pages\ViewComponent;
use App\Filament\Resources\Activities\Resources\Components\RelationManagers\ComponentAuditsRelationManager;
use App\Filament\Resources\Activities\Resources\Components\Resources\Reports\RelationManagers\ReportsRelationManager;
use App\Filament\Resources\Activities\Resources\Components\Schemas\ComponentForm;
use App\Filament\Resources\Activities\Resources\Components\Tables\ComponentsTable;
use App\Models\Component;
use BackedEnum;
use Filament\Actions\CreateAction;
use Filament\Resources\ParentResourceRegistration;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Hexters\HexaLite\HasHexaLite;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ComponentResource extends Resource
{
    use HasHexaLite;

    protected static ?string $model = Component::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = ActivityResource::class;

    protected static ?string $recordTitleAttribute = 'name';

    public function roleName()
    {
        return __('Component');
    }

    public static function canAccess(): bool
    {
        return hexa()->can('component.index');
    }

    public function defineGates(): array
    {
        return [
            'component.index' => __('Allows viewing the component list'),
            'component.create' => __('Allows creating a new component'),
            'component.update' => __('Allows updating components'),
            'component.view' => __('Allows view components'),
            'component.delete' => __('Allows deleting components'),
            'component.delete.force' => __('Allows deleteing components (Force)'),
            'component.restore' => __('Allows restore components'),
            'component.audit.index' => __('Allows view audit components'),
            'component.audit.restore' => __('Allows resotre audit components')
        ];
    }


    public static function getNavigationLabel(): string
    {
        return __('Component Menu');
    }

    public static function form(Schema $schema): Schema
    {
        return ComponentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ComponentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make(__('Montly Reports'), [
                'components' => ReportsRelationManager::make(),
            ]),
            RelationGroup::make(__('Changelog'), [
                'Audit' => ComponentAuditsRelationManager::make(),
            ])
        ];
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateComponent::route('/create'),
            'edit' => EditComponent::route('/{record}/edit'),
            'view' => ViewComponent::route('/{record}/view'),

        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getParentResourceRegistration(): ?ParentResourceRegistration
    {
        return ActivityResource::asParent()
            ->relationship('components')
            ->inverseRelationship('activity');
    }
}

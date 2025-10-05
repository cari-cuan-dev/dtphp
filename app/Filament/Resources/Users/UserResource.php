<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\RelationManagers\UserAuditsRelationManager;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Hexters\HexaLite\HasHexaLite;
use Tapp\FilamentAuditing\RelationManagers\AuditsRelationManager;

class UserResource extends Resource
{
    use HasHexaLite;

    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return UsersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationGroup::make(__('Changelog'), [
                'Audit' => UserAuditsRelationManager::make(['view' => true]),
            ])
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('User');
    }


    public static function canAccess(): bool
    {
        return hexa()->can('user.index');
    }

    public function defineGates(): array
    {
        return [
            'user.index' => __('View data'),
            'user.create' => __('Creating data'),
            'user.update' => __('Updating data'),
            'user.delete' => __('Deleting data'),
            // 'user.view' => __('View spesific data'),
            'user.impersonate' => __('Impersonate user'),
            'user.audit.index' => __('View audit data'),
            'user.audit.restore' => __('Resotre audit data'),
        ];
    }
}

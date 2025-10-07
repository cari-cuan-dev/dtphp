<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('Name'))
                    ->searchable(),
                TextColumn::make('username')
                    ->label(__('Username'))
                    ->searchable(),
                TextColumn::make('email')
                    ->label(__('Email Address'))
                    ->searchable(),
                TextColumn::make('roles.name')
                    ->label(__('Role Name'))
                    ->badge()
                    ->bulleted()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->visible(fn() => hexa()->can('user.update')),
                DeleteAction::make()
                    ->visible(fn() => hexa()->can('user.delete')),
                Impersonate::make()
                    ->visible(fn() => hexa()->can('user.impersonate')),
            ])
            ->recordAction(fn() => hexa()->can('user.update') ? 'edit' : null)
            ->recordUrl(fn($record) => hexa()->can('user.update') ? UserResource::getUrl('edit', ['record' => $record]) : null)
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                // ]),
            ]);
    }
}

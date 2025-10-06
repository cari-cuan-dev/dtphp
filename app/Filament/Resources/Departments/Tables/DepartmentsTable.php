<?php

namespace App\Filament\Resources\Departments\Tables;

use App\Filament\Resources\Departments\DepartmentResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DepartmentsTable
{
    public static function configure(Table $table): Table
    {
        // return $table
        //     ->columns([
        //         //
        //     ])
        //     ->filters([
        //         //
        //     ])
        //     ->recordActions([
        //         EditAction::make(),
        //     ])
        //     ->toolbarActions([
        //         BulkActionGroup::make([
        //             DeleteBulkAction::make(),
        //         ]),
        //     ]);
        return $table
            ->modifyQueryUsing(fn($query) => $query->where('guard', hexa()->guard()))
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->label(__('Role Name')),
                TextColumn::make('description')
                    ->searchable()
                    ->label(__('Description')),
                TextColumn::make('created_by_name')
                    ->searchable()
                    ->label(__('Crated By')),
                TextColumn::make('created_at')
                    ->sortable()
                    ->dateTime('d/m/y H:i')
                    ->label(__('Crated At')),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->button()
                    ->visible(fn() => hexa()->can('role.update')),
                DeleteAction::make()
                    ->button()
                    ->visible(fn() => hexa()->can('role.delete')),
            ])

            ->recordAction(fn() => hexa()->can('role.update') ? 'edit' : null)
            ->recordUrl(
                function ($record) {
                    if (hexa()->can('role.update'))
                        return DepartmentResource::getUrl('edit', ['record' => $record]);
                    return null;
                }
            )
            ->toolbarActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make()
                //     // ->visible(fn() => hexa()->can('department.delete'))
                //     ,
                // ]),
            ]);
    }
}

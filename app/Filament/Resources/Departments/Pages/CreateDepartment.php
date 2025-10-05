<?php

namespace App\Filament\Resources\Departments\Pages;

use App\Filament\Resources\Departments\DepartmentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['access'] = $data['gates'] ?? [];
        $data['guard'] = hexa()->guard();
        $data['created_by_name'] = Auth::user()->name;

        return $data;
    }
}

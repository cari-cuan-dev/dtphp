<?php

namespace App\Filament\Resources\Activities\Resources\Components\Resources\Reports\Classes;

use Filament\Facades\Filament;

class MutateData
{
    public static function before_creation(array $data): array
    {
        $data['physical_volume'] = $data['physical_volume'] ?? 0;

        $data['realization_capital'] = $data['realization_capital'] ?? 0;
        $data['realization_good'] = $data['realization_good'] ?? 0;
        $data['realization_employee'] = $data['realization_employee'] ?? 0;
        $data['realization_social'] = $data['realization_social'] ?? 0;

        return $data;
    }

    public static function before_update(array $data): array
    {
        return self::before_creation($data);
    }
}

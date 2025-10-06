<?php

// namespace Hexters\HexaLite\Models;
namespace App\Models;

use App\Models\Team;
use Filament\Facades\Filament;
use Hexters\HexaLite\Helpers\UuidGenerator;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Role extends Model implements Auditable
{
    use UuidGenerator;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'description',
        'created_by_name',
        'access',
        'team_id',
        'guard',
    ];

    protected $casts = [
        'access' => 'array'
    ];

    // public function team()
    // {
    //     return $this->belongsTo(Filament::getTenantModel());
    // }
}

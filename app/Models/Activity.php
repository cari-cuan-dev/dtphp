<?php

namespace App\Models;

use Hexters\HexaLite\HexaLiteRolePermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use OwenIt\Auditing\Contracts\Auditable;

class Activity extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'role_id',
        'year',
        'code',
        'label',
        'volume',
        'unit',
        'description'
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    public function components(): HasMany
    {
        return $this->hasMany(Component::class);
    }
    public function reports(): HasManyThrough
    {
        return $this->hasManyThrough(Report::class, Component::class);
    }

    public function created_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updated_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function deleted_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // function

    public function getAllocation()
    {
        return $this->components()
            ->sum('allocation_total');
    }
}

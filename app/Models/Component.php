<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Component extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'activity_id',
        'code',
        'label',
        'volume',
        'unit',
        'allocation_total',
        'allocation_capital',
        'allocation_good',
        'allocation_employee',
        'allocation_social',
        'description'
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
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
}

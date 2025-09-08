<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Report extends Model implements Auditable
{
    use SoftDeletes;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'component_id',
        'month',

        // realization physical
        'physical_volume',
        'physical_unit',
        'physical_real',
        'physical_unit',
        'physical_category',
        'physical_status',

        // realization
        'realization_capital',
        'realization_good',
        'realization_employee',
        'realization_social',

        // implementation
        'implementation_progress',
        'implementation_category',
        'implementation_description',

        // issue
        'issue_is_solve',
        'issue_description',

        // supporting evidence
        'support_document_path',
        'support_photo_path',
        'support_video_path',

        // verified
        'verified',
        'verified_at',
        'verified_by',
        'verified_notes',

    ];

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }
    public function activity(): HasOneThrough
    {
        return $this->hasOneThrough(Activity::class, Component::class);
    }
    public function verified_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
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

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel\Concerns\HasNotifications;
use Hexters\HexaLite\HexaLiteRolePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use SoftDeletes;
    use HasNotifications;
    use \OwenIt\Auditing\Auditable;
    // use HexaLiteRolePermission;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(
            config('hexa.models.role'),
            'role_user',
            'user_id',
            'role_id'
        )->where('guard', hexa()->guard());
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

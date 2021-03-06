<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use OneUpReviews\Models\Traits\Uuidable;

/**
 * @property int id
 * @property int organization_id
 * @property string first_name
 * @property string last_name
 * @property string email
 * @property string password
 * @property bool is_superadmin
 * @property string full_name
 *
 * @property Organization organization
 */
class User extends BaseEloquentModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    JWTSubject
{
    use Authenticatable, Authorizable, CanResetPassword, HasRoles, Notifiable, Uuidable;

    protected $fillable = [
        'uuid',
        'organization_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'created_by',
        'force_password_change',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'full_name',
    ];

    protected $with = [
        'organization',
    ];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_superadmin;
    }

    public function getJWTIdentifier(): int
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'organization_id' => $this->organization->id,
            'subscription_plan' => $this->organization->subscription()
        ];
    }

    public function getOrganizationId(): int
    {
        return $this->organization_id;
    }
}

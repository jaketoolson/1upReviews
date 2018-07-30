<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OneUpReviews\Models\Traits\BelongsToTenants;
use OneUpReviews\Models\Traits\Uuidable;

/**
 * @property int id
 * @property int organization_id
 * @property string first_name
 * @property string last_name
 * @property string|null business_name
 * @property string email_address
 * @property string name
 * @property string full_name
 *
 * @property Collection emails
 */
class Client extends BaseEloquentModel
{
    use BelongsToTenants, SoftDeletes, Uuidable;

    protected $table = 'clients';

    protected $with = [
        'emails',
    ];

    protected $appends = [
        'full_name',
    ];

    protected $fillable = [
        'uuid',
        'organization_id',
        'first_name',
        'last_name',
        'business_name',
        'email_address',
    ];

    protected $hidden = [
        'id',
        'organization_id',
    ];

    public function emails(): HasMany
    {
        return $this->hasMany(CampaignEmail::class, 'client_id')->orderBy('created_at', 'desc');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getLastEmail(): ?CampaignEmail
    {
        return $this->emails->first();
    }
}

<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string name
 * @property int company_id
 * @property string|null description
 *
 * @property Collection|User[] users
 */
class Campaign extends BaseEloquentModel
{
    use SoftDeletes, Uuidable;

    protected $table = 'campaigns';

    protected $fillable = [
        'uuid',
        'name',
        'company_id',
        'description',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'company_user', 'company_id');
    }
}

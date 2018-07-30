<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use OneUpReviews\Models\Traits\Uuidable;

/**
 * @property int id
 * @property string name
 * @property int organization_id
 * @property string|null description
 */
class Campaign extends BaseEloquentModel
{
    use SoftDeletes, Uuidable;

    protected $table = 'campaigns';

    protected $fillable = [
        'uuid',
        'name',
        'organization_id',
        'description',
    ];
}

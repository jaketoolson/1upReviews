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
 */
class Company extends BaseEloquentModel
{
    use SoftDeletes, Uuidable;

    protected $table = 'companies';

    protected $fillable = [
        'uuid',
        'name',
    ];
}

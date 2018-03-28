<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Query\Builder;

class Criteria implements CriteriaInterface
{
    public function apply(Builder $query): Builder
    {
        return $query->where('1', '=', 1);
    }
}

<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Query\Builder;

interface CriteriaInterface
{
    public function apply(Builder $query): Builder;
}

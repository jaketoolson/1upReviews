<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Database\Eloquent\Builder;

class BaseEloquentBuilder extends Builder
{
    /**
     * @var array|CriteriaInterface[]
     */
    protected $criteria = [];

    public function applyCriteria(CriteriaInterface $criteria): BaseEloquentBuilder
    {
        $this->criteria[] = $criteria;
        $criteria->apply($this);

        return $this;
    }

    public function getCriteria(): array
    {
        return $this->criteria;
    }
}

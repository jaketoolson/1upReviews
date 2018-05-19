<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class BaseEloquentBuilder extends Builder
{
    /**
     * @var array|CriteriaInterface[]
     */
    protected $criteria = [];

    public function applyCriteria(Collection $criteria): QueryBuilder
    {
        $criteria->each(function (CriteriaInterface $criterion) {
            $this->criteria[] = $criterion;
            $this->setQuery($criterion->apply($this->getQuery()));
        });

        return $this->getQuery();
    }

    public function getCriteria(): array
    {
        return $this->criteria;
    }
}

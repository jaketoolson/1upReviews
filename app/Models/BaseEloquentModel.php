<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseEloquentModel extends Model
{
    public function newEloquentBuilder($query): BaseEloquentBuilder
    {
        return new BaseEloquentBuilder($query);
    }

    public function getCreatedAtAttribute(string $value = null): ?string
    {
        return $this->formatDate($value);
    }

    public function getUpdatedAtAttribute(string $value = null): ?string
    {
        return $this->formatDate($value);
    }

    public function formatDate(string $date = null): ?string
    {
        if (! $date) {
            return null;
        }

        return Carbon::parse($date)->format('M d, Y h:m');
    }
}

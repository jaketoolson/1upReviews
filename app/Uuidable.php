<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews;

/**
 * @property string uuid
 */
trait Uuidable
{
    public static function bootUuidable(): void
    {
        self::creating(function($model){
            $model->uuid = self::makeUuid($model->name ?? null);
        });
    }

    public static function makeUuid(string $salt = null): string
    {
        return sha1($salt ?? str_random(16));
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }
}

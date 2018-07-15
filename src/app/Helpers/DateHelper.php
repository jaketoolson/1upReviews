<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Helpers;

use Carbon\Carbon;

class DateHelper
{
    public const FORMAT = 'F d, Y';

    public static function convertTimestampToFormat(string $date): string
    {
        return Carbon::createFromTimeString($date)->format(self::FORMAT);
    }
}

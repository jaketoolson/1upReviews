<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    public const APP_VERSION = '0.0.1';

    public static function getAppVersion(): string
    {
        return self::APP_VERSION;
    }
}

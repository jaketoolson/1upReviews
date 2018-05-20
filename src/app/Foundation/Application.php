<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{
    public const ONEUP_VERSION = '0.0.1';

    public static function getAppVersion(): string
    {
        return self::ONEUP_VERSION;
    }

    public function isProductionEnvironment(): bool
    {
        return $this->environment() === 'production';
    }

    public function isNotProductionEnvironment(): bool
    {
        return !$this->isProductionEnvironment();
    }

    public function isLocalEnvironment(): bool
    {
        return $this->environment() === 'local';
    }
}

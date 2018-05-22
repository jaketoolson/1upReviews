<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Libraries\Keen;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\ServiceProvider;

class KeenServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(KeenClient::class, function($app) {
            $config = $app['config']['services']['keen'];

            /** @var Guard $guard */
            $guard = app(Guard::class);
            if ($guard->check()) {
                $tenantReadKey = $guard->user()->getTenant()->getKeenReadKey();
                if ($tenantReadKey) {
                    $config['read_key'] = $tenantReadKey;
                }
            }

            return (KeenClient::factory([
                'projectId' => $config['project_id'],
                'masterKey' => $config['master_key'],
                'writeKey'  => $config['write_key'],
                'readKey'   => $config['read_key']
            ]));
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            KeenClient::class
        ];
    }
}
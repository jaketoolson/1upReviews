<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services\Postmark;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class PostmarkServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $config = $this->app['config']->get('services.postmark', []);

        $this->app['swift.transport']->extend('postmark', function () use ($config) {
            return new PostmarkTransport(
                $this->guzzle($config),
                $config['secret']
            );
        });
    }

    protected function guzzle(array $config = []): HttpClient
    {
        return new HttpClient(array_add(
            array_get($config, 'guzzle', []),
            'connect_timeout',
            60
        ));
    }
}

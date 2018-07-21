<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Foundation\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use OneUpReviews\Events\CampaignEmailCreated;
use OneUpReviews\Listeners\SendCampaignEmailForResponse;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CampaignEmailCreated::class => [
            SendCampaignEmailForResponse::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}

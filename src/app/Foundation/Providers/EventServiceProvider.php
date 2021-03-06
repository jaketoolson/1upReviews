<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Foundation\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Mail\Events\MessageSending;
use Illuminate\Mail\Events\MessageSent;
use OneUpReviews\Events\CampaignEmailCreated;
use OneUpReviews\Events\OrganizationCreatingEvent;
use OneUpReviews\Listeners\MailSending;
use OneUpReviews\Listeners\MailSent;
use OneUpReviews\Listeners\SendCampaignEmailForResponse;
use OneUpReviews\Listeners\SetOrganizationToGenericTrial;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        CampaignEmailCreated::class => [
            SendCampaignEmailForResponse::class,
        ],

        OrganizationCreatingEvent::class => [
            SetOrganizationToGenericTrial::class,
        ],

        MessageSending::class => [
            MailSending::class,
        ],
        MessageSent::class => [
            MailSent::class,
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

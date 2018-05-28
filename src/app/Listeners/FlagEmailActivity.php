<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use OneUpReviews\Events\CampaignEmailActivityStored;
use OneUpReviews\Services\CampaignEmailService;

class FlagEmailActivity
{
    /**
     * @var CampaignEmailService
     */
    protected $emailService;

    /**
     * @param CampaignEmailService $emailService
     */
    public function __construct(CampaignEmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function handle(CampaignEmailActivityStored $event): void
    {
        $emailActivity = $event->getCampaignEmailActivity();

        $emailActivity->email()->update([
            'is_' . $emailActivity->type => 1
        ]);
    }
}

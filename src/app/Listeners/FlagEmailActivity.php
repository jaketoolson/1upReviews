<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use OneUpReviews\Services\EmailService;
use OneUpReviews\Events\EmailActivityStored;

class FlagEmailActivity
{
    /**
     * @var EmailService
     */
    protected $emailService;

    /**
     * @param EmailService $emailService
     */
    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * @param EmailActivityStored $event
     */
    public function handle(EmailActivityStored $event)
    {
        $emailActivity = $event->getEmailActivity();

        $emailActivity->getEmail()->update([
            'is_' . $emailActivity->getType() => 1
        ]);
    }
}

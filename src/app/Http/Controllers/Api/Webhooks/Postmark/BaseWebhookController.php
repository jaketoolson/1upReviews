<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Api\Webhooks\Postmark;

use OneUpReviews\Services\PostmarkService;
use OneUpReviews\Services\EmailActivityService;
use OneUpReviews\Http\Controllers\Controller;

class BaseWebhookController extends Controller
{
    /**
     * @var EmailActivityService
     */
    protected $emailActivityService;

    /**
     * @param EmailActivityService $emailActivityService
     */
    public function __construct(EmailActivityService $emailActivityService)
    {
        $this->emailActivityService = $emailActivityService;
    }

    /**
     * @return EmailActivityService
     */
    public function getEmailActivityService(): EmailActivityService
    {
        return $this->emailActivityService;
    }
}

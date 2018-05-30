<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Api\Webhooks\Postmark;

use OneUpReviews\Services\CampaignEmailActivityService;
use OneUpReviews\Http\Controllers\Controller;

class BaseWebhookController extends Controller
{
    protected $campaignEmailActivityService;

    public function __construct(CampaignEmailActivityService $campaignEmailActivityService)
    {
        $this->campaignEmailActivityService = $campaignEmailActivityService;
    }

    public function getCampaignEmailActivityService(): CampaignEmailActivityService
    {
        return $this->campaignEmailActivityService;
    }
}

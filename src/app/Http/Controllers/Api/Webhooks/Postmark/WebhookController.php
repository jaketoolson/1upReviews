<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Api\Webhooks\Postmark;

use OneUpReviews\Http\Requests\PostmarkWebhookRequest;
use OneUpReviews\Services\CampaignEmailActivityService;
use OneUpReviews\Http\Controllers\Controller;

class WebhookController extends Controller
{
    /**
     * @var CampaignEmailActivityService
     */
    protected $campaignEmailActivityService;

    public function __construct(CampaignEmailActivityService $campaignEmailActivityService)
    {
        $this->campaignEmailActivityService = $campaignEmailActivityService;
    }

    public function store(PostmarkWebhookRequest $request)
    {
        if ($request->recordTypeDelivered()) {

        } elseif ($request->recordTypeBounced()) {

        } elseif ($request->recordTypeOpened()) {

        } elseif ($request->recordTypeLinkClicked()) {

        }

        return $this->json(['ok']);
     }
}

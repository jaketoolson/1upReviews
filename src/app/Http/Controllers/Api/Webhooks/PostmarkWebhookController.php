<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Api\Webhooks;

use OneUpReviews\Http\Requests\PostmarkWebhookRequest;
use OneUpReviews\Services\CampaignEmailActivityService;
use OneUpReviews\Http\Controllers\Controller;
use OneUpReviews\Services\Postmark\WebhookResponses\BounceResponse;
use OneUpReviews\Services\Postmark\WebhookResponses\DeliveredResponse;
use OneUpReviews\Services\Postmark\WebhookResponses\OpenedResponse;

class PostmarkWebhookController extends Controller
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
        $content = $request->all();
        if ($request->emailTypeBounced()) {
            $this->campaignEmailActivityService->storeBounce(BounceResponse::factory($content));
        } elseif ($request->emailTypeDelivered()) {
            $this->campaignEmailActivityService->storeDelivered(DeliveredResponse::factory($content));
        } elseif ($request->emailTypeOpened()) {
            $this->campaignEmailActivityService->storeOpened(OpenedResponse::factory($content));
        } elseif ($request->emailTypeLinkClinked()) {

        }

        return $this->json(['ok']);
     }
}

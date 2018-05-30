<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Api\Webhooks\Postmark;

use Illuminate\Http\JsonResponse;
use OneUpReviews\Http\Requests\PostmarkWebhookRequest;
use OneUpReviews\Services\Postmark\WebhookResponses\BounceResponse;

class BounceWebhookController extends BaseWebhookController
{
    public function store(PostmarkWebhookRequest $request): JsonResponse
    {
        $bounceResponse = BounceResponse::factory($request->getContent());
        $activity = $this->getCampaignEmailActivityService()->storeBounce($bounceResponse);

        return $this->json($activity->id, 200);
    }
}

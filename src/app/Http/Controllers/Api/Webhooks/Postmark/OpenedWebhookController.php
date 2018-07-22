<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Api\Webhooks\Postmark;

use Illuminate\Http\JsonResponse;
use OneUpReviews\Http\Requests\PostmarkWebhookRequest;
use OneUpReviews\Services\Postmark\WebhookResponses\OpenedResponse;

class OpenedWebhookController extends WebhookController
{
    public function store(PostmarkWebhookRequest $request): JsonResponse
    {
        $bounceResponse = OpenedResponse::factory($request->getContent());
        $activity = $this->getCampaignEmailActivityService()->storeOpened($bounceResponse);

        return $this->json($activity->id, 200);
    }
}

<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Controllers\Api\Webhooks\Postmark;

use OneUpReviews\Http\Requests\PostmarkWebhookRequest;
use OneUpReviews\Services\Postmark\WebhookResponses\OpenedResponse;

class OpenedWebhookController extends BaseWebhookController
{
    /**
     * @param PostmarkWebhookRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PostmarkWebhookRequest $request)
    {
        $bounceResponse = OpenedResponse::factory($request->getContent());
        $activity = $this->getEmailActivityService()->storeOpened($bounceResponse);

        return response()->json($activity->getId(), 200);
    }
}

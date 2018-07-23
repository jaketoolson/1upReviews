<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use OneUpReviews\Models\CampaignEmailActivity;
use OneUpReviews\Events\CampaignEmailActivityStored;
use OneUpReviews\Services\Postmark\WebhookResponses\OpenedResponse;
use OneUpReviews\Services\Postmark\WebhookResponses\BounceResponse;
use OneUpReviews\Services\Postmark\WebhookResponses\DeliveredResponse;

class CampaignEmailActivityService
{
    /**
     * @var CampaignEmailService
     */
    protected $campaignEmailService;

    public function __construct(CampaignEmailService $campaignEmailService)
    {
        $this->campaignEmailService = $campaignEmailService;
    }

    public function storeBounce(BounceResponse $response): CampaignEmailActivity
    {
        $email = $this->campaignEmailService->findWithNoGlobalScope('provider_message_id', $response->getMessageId());

        return $this->createActivity(
            $email->id,
            $response->getJsonString(),
            CampaignEmailActivity::TYPE_BOUNCED
        );
    }

    public function storeDelivered(DeliveredResponse $response): CampaignEmailActivity
    {
        $email = $this->campaignEmailService->findWithNoGlobalScope('provider_message_id', $response->getMessageId());

        return $this->createActivity(
            $email->id,
            $response->getJsonString(),
            CampaignEmailActivity::TYPE_DELIVERED
        );
    }

    public function storeOpened(OpenedResponse $response): CampaignEmailActivity
    {
        $email = $this->campaignEmailService->findWithNoGlobalScope('provider_message_id', $response->getMessageId());

        return $this->createActivity(
            $email->id,
            $response->getJsonString(),
            CampaignEmailActivity::TYPE_OPENED
        );
    }

    private function createActivity(int $emailId, string $jsonString, string $type): CampaignEmailActivity
    {
        $activity = CampaignEmailActivity::create([
            'campaign_email_id' => $emailId,
            'raw_json' => $jsonString,
            'type' => $type,
        ]);

        event(new CampaignEmailActivityStored($activity));

        return $activity;
    }
}

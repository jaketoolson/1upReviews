<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Services;

use Carbon\Carbon;
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
    protected $emailService;

    public function __construct(CampaignEmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    public function storeBounce(BounceResponse $response): CampaignEmailActivity
    {
        $email = $this->emailService->findWithNoGlobalScope('provider_message_id', $response->getMessageId());

        return $this->createActivity(
            $email->id,
            $response->getJsonString(),
            CampaignEmailActivity::TYPE_BOUNCED,
            $response->getBouncedAt()
        );
    }

    public function storeDelivered(DeliveredResponse $response): CampaignEmailActivity
    {
        $email = $this->emailService->findWithNoGlobalScope('provider_message_id', $response->getMessageId());

        return $this->createActivity(
            $email->id,
            $response->getJsonString(),
            CampaignEmailActivity::TYPE_DELIVERED,
            $response->getDeliveredAt()
        );
    }

    public function storeOpened(OpenedResponse $response): CampaignEmailActivity
    {
        $email = $this->emailService->findWithNoGlobalScope('provider_message_id', $response->getMessageId());

        return $this->createActivity(
            $email->id,
            $response->getJsonString(),
            CampaignEmailActivity::TYPE_OPENED,
            $response->getReceivedAt()
        );
    }

    private function createActivity(int $emailId, string $jsonString, string $type, Carbon $date): CampaignEmailActivity
    {
        $activity = CampaignEmailActivity::create([
            'email_id' => $emailId,
            'raw_json' => $jsonString,
            'type' => $type,
            'activity_date' => $date->toDateTimeString()
        ]);

        event(new CampaignEmailActivityStored($activity));

        return $activity;
    }
}

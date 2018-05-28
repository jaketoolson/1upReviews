<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use KeenIO\Client\KeenIOClient;
use OneUpReviews\Libraries\Keen\Keen;
use OneUpReviews\Events\EmailFeedbackRequestSentToClient;
use OneUpReviews\Libraries\Keen\KeenClient;

class SaveFeedbackRequestToKeen
{
    protected $keen;

    public function __construct(KeenClient $keen)
    {
        $this->keen = $keen;
    }

    public function handle(EmailFeedbackRequestSentToClient $event)
    {
        $email = $event->getEmail()->fresh([
            'tenant',
            'client',
            'campaign'
        ]);
        $tenant = $email->getTenant();
        $client = $email->getClient();
        $campaign = $email->getEmailCampaign();

        $event = [
            'id' => $email->getId(),
            'raw' => $email->toArray(),
            'recipient' => $email->getRecipientEmail(),

            'tenant_id' => $tenant->getId(),
            'client_id' => $client->getId(),
            'email_campaign_id' => $campaign->getId(),

            'tenant' => [
                'id' => $tenant->getId(),
                'raw' => $tenant->toArray(),
                'name' => $tenant->getName()
            ],

            'emailCampaign' => [
                'id' => $campaign->getId(),
                'raw' => $campaign->toArray(),
                'name' => $campaign->getName(),
                'is_primary' => $campaign->isPrimary(),
                'status' => $campaign->getStatus(),
            ],

            'client' => [
                'id' => $client->getId(),
                'raw' => $client->toArray(),
                'name' => $client->getName(),
                'business_name' => $client->getBusinessName()
            ]
        ];

        $this->keen->addEvent('emailFeedbackRequests', $event);
    }
}

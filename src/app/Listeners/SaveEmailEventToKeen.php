<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use OneUpReviews\Events\CampaignEmailActivityStored;
use OneUpReviews\Libraries\Keen\Keen;
use OneUpReviews\Libraries\Keen\KeenClient;

class SaveEmailEventToKeen
{
    protected $keen;

    public function __construct(KeenClient $keen)
    {
        $this->keen = $keen;
    }

    public function handle(CampaignEmailActivityStored $event)
    {
        $emailActivity = $event->getEmailActivity()->fresh([
            'email',
            'email.tenant',
            'email.client',
            'email.campaign'
        ]);
        $email = $emailActivity->getEmail();
        $tenant = $email->getTenant();
        $client = $email->getClient();
        $campaign = $email->getEmailCampaign();

        $event = [
            'id' => $emailActivity->getId(),
            'uuid' => $emailActivity->getUuid(),
            'raw' => $emailActivity->toArray(),
            'type' => $emailActivity->getType(),

            'tenant_id' => $tenant->getId(),
            'email_campaign_id' => $campaign->getId(),
            'email_id' => $emailActivity->getEmailId(),
            'client_id' => $client->getId(),

            'tenant' => [
                'id' => $tenant->getId(),
                'raw' => $tenant->toArray(),
                'name' => $tenant->getName()
            ],

            'email' => [
                'id' => $email->getId(),
                'raw' => $email->toArray(),
                'recipient' => $email->getRecipientEmail()
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

        $this->keen->addEvent('emailActivities', $event);
    }
}

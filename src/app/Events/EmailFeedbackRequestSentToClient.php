<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

use OneUpReviews\Models\Client;
use OneUpReviews\Models\CampaignEmail;

class EmailFeedbackRequestSentToClient
{
    private $campaignEmail;
    private $client;

    public function __construct(CampaignEmail $campaignEmail, Client $client)
    {
        $this->campaignEmail = $campaignEmail;
        $this->client = $client;
    }

    public function getCampaignEmail(): CampaignEmail
    {
        return $this->campaignEmail;
    }

    public function getClient(): Client
    {
        return $this->client;
    }
}

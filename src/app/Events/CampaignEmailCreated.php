<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

class CampaignEmailCreated
{
    private $campaignEmailId;

    public function __construct(int $campaignEmailId)
    {
        $this->campaignEmailId = $campaignEmailId;
    }

    public function getCampaignEmailId(): int
    {
        return $this->campaignEmailId;
    }
}

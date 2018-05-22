<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

use OneUpReviews\Models\CampaignEmailActivity;

class CampaignEmailActivityStored
{
    private $campaignEmailActivity;

    public function __construct(CampaignEmailActivity $campaignEmailActivity)
    {
        $this->campaignEmailActivity = $campaignEmailActivity;
    }

    public function getCampaignEmailActivity(): CampaignEmailActivity
    {
        return $this->campaignEmailActivity;
    }
}

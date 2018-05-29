<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use Illuminate\Support\Facades\Mail;
use OneUpReviews\Events\CampaignEmailCreated;
use OneUpReviews\Mail\Reminder;
use OneUpReviews\Models\CampaignEmail;
use OneUpReviews\Services\CampaignEmailService;

class SendCampaignEmailForResponse
{
    private $campaignEmailService;

    public function __construct(CampaignEmailService $campaignEmailService)
    {
        $this->campaignEmailService = $campaignEmailService;
    }

    public function handle(CampaignEmailCreated $event): void
    {
        $campaignEmail = $this->getCampaignEmail($event->getCampaignEmailId());

        Mail::to($campaignEmail->recipient_email)->send(new Reminder($campaignEmail));
    }

    private function getCampaignEmail(int $campaignEmailId): CampaignEmail
    {
        return $this->campaignEmailService->findEmail('id', $campaignEmailId);
    }
}

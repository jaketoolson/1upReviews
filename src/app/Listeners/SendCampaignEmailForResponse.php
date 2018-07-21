<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use Illuminate\Contracts\Mail\Mailer;
use OneUpReviews\Events\CampaignEmailCreated;
use OneUpReviews\Mail\Reminder;
use OneUpReviews\Models\CampaignEmail;
use OneUpReviews\Services\CampaignEmailService;

class SendCampaignEmailForResponse
{
    private $mailer;
    private $campaignEmailService;

    public function __construct(Mailer $mailer, CampaignEmailService $campaignEmailService)
    {
        $this->mailer = $mailer;
        $this->campaignEmailService = $campaignEmailService;
    }

    public function handle(CampaignEmailCreated $event): void
    {
        $campaignEmail = $this->getCampaignEmail($event->getCampaignEmailId());

        $this->mailer->to($campaignEmail->recipient_email)->send(new Reminder($campaignEmail));
    }

    private function getCampaignEmail(int $campaignEmailId): CampaignEmail
    {
        return $this->campaignEmailService->findEmail('id', $campaignEmailId);
    }
}

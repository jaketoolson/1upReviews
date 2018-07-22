<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use Illuminate\Mail\Events\MessageSending;
use OneUpReviews\Mail\MailHeaders;
use OneUpReviews\Models\CampaignEmail;

class MailSending
{
    public function handle(MessageSending $event): void
    {
        $message = $event->message;
        $headers = $message->getHeaders();

        $campaignEmailId = $headers->get(MailHeaders::HEADER_CAMPAIGN_EMAIL_ID)->getFieldBody();

        $email = CampaignEmail::find($campaignEmailId);
        $email->origin_message_id = $message->getId();
        $email->save();
    }
}

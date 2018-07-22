<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use Illuminate\Mail\Events\MessageSent;
use OneUpReviews\Mail\MailHeaders;
use OneUpReviews\Models\CampaignEmail;

class MailSent
{
    public function handle(MessageSent $event): void
    {
        $message = $event->message;
        $headers = $message->getHeaders();

        $campaignEmailId = $headers->get(MailHeaders::HEADER_CAMPAIGN_EMAIL_ID)->getFieldBody();
        $providerMessageId = $headers->get(MailHeaders::HEADER_MESSAGE_ID)->getFieldBody();

        $email = CampaignEmail::find($campaignEmailId);
        $email->provider_message_id = $this->cleanMessageId($providerMessageId);
        $email->save();

//        event(new EmailFeedbackRequestSentToClient($email, $email->getClient()));
    }

    /**
     * This trims and returns only the uniqueid value found within "<uniqueid@localhost>";
     *
     * @param string $messageId
     * @return string
     */
    private function cleanMessageId(string $messageId): string
    {
        return strtok(trim($messageId, '<>'), '@');
    }
}

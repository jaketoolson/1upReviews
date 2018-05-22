<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use Swift_Events_SendEvent;
use Swift_Events_EventListener;
use OneUpReviews\Services\EmailService;
use OneUpReviews\Events\EmailFeedbackRequestSentToClient;

class EmailSent implements Swift_Events_EventListener
{
    /**
     * @var EmailService
     */
    protected $emailService;

    public function __construct()
    {
        // Can't inject :(
        $this->emailService = app(EmailService::class);
    }

    /**
     * @param Swift_Events_SendEvent $message
     */
    public function sendPerformed(Swift_Events_SendEvent $message)
    {
        $headers = $message->getMessage()->getHeaders();
        $swiftMessageId = $headers->get('Message-ID')->getId();
        $providerMessageId = $headers->get('X-PM-Message-Id')->getFieldBodyModel();

        $email = $this->emailService->findWithNoGlobalScope('origin_message_id', $swiftMessageId);
        $email->provider_message_id = $providerMessageId;
        $email->save();

        event(new EmailFeedbackRequestSentToClient($email, $email->getClient()));
    }
}

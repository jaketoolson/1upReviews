<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use Swift_Events_SendEvent;
use Swift_Events_EventListener;
use OneUpReviews\Models\CampaignEmail;
use OneUpReviews\Services\CampaignEmailService;
use OneUpReviews\Events\EmailFeedbackRequestSentToClient;

class CampaignEmailPlugin implements Swift_Events_EventListener
{
    /**
     * @var CampaignEmailService
     */
    protected $emailService;

    /**
     * @var CampaignEmail
     */
    private $campaignEmail;

    public function __construct(CampaignEmail $campaignEmail)
    {
        $this->campaignEmail = $campaignEmail;

        // Can't inject :(
        $this->emailService = app(CampaignEmailService::class);
    }

    /**
     * Before an email is sent, retrieve the entity Id and associate it to the email
     *
     * @param Swift_Events_SendEvent $event
     * @return void
     */
    public function beforeSendPerformed(Swift_Events_SendEvent $event): void
    {
        $email = $this->campaignEmail;
        $email->origin_message_id = $event->getMessage()->getId();
        $email->save();
    }

    /**
     * When an email was sent successfully, associate the response id to the origin email.
     *
     * @param Swift_Events_SendEvent $event
     * @return void
     */
    public function sendPerformed(Swift_Events_SendEvent $event): void
    {
        $headers = $event->getMessage()->getHeaders();
        $providerMessageId = $headers->get('X-PM-Message-Id')->getFieldBodyModel();

        $email = $this->campaignEmail;
        $email->provider_message_id = $providerMessageId;
        $email->save();

        event(new EmailFeedbackRequestSentToClient($email, $email->getClient()));
    }
}

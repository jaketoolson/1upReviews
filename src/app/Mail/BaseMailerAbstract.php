<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Mail;

use Swift_Message;
use OneUpReviews\Models\CampaignEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

abstract class BaseMailerAbstract extends Mailable implements MailHeaders
{
    use Queueable, SerializesModels;

    /**
     * @var CampaignEmail
     */
    protected $email;

    public function __construct(CampaignEmail $email)
    {
        $this->email = $email;

        $this->withSwiftMessage(function(Swift_Message $message) use ($email) {
            $message->getHeaders()->addTextHeader(self::HEADER_CAMPAIGN_EMAIL_ID, $email->id);
            $message->getHeaders()->addTextHeader(self::HEADER_ORGANIZATION_ID, $email->organization_id);

            return $message;
        });
    }

    abstract public function build(): Mailable;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBaseMailView()
    {
        return view('mail.base');
    }
}

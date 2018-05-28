<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Mail;

use Swift_Message;
use OneUpReviews\Models\CampaignEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use OneUpReviews\Listeners\EmailSent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

abstract class BaseMailerAbstract extends Mailable
{
    use Queueable, SerializesModels;

    protected $email;

    public function __construct(CampaignEmail $email)
    {
        Mail::getSwiftMailer()->registerPlugin(new EmailSent());

        $this->email = $email;

        $this->withSwiftMessage(function (Swift_Message $swiftmessage) use ($email) {
            $email->origin_message_id = $swiftmessage->getId();
            $email->save();
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

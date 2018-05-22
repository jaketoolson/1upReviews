<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Mail;

use Swift_Message;
use OneUpReviews\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use OneUpReviews\Listeners\EmailSent;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;

abstract class BaseEmailAbstract extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Email
     */
    protected $email;

    /**
     * @param Email $email
     */
    public function __construct(Email $email)
    {
        Mail::getSwiftMailer()->registerPlugin(new EmailSent());

        $this->email = $email;

        $this->withSwiftMessage(function(Swift_Message $swiftmessage) use ($email) {
            $email->origin_message_id = $swiftmessage->getId();
            $email->save();
        });
    }

    /**
     * @return void
     */
    public abstract function build();

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBaseMailView()
    {
        return view('mail.base');
    }
}

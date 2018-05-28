<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Mail;

use Illuminate\Mail\Mailable;

class Reminder extends BaseMailerAbstract
{
    public function build(): Mailable
    {
        $this->subject('test');

        $email = $this->email;
        $hashedId = $email->getHashedId();

        return $this->view('mail.feedbackrequest')
            ->with('subject', 'test')
            ->with('recommendUrl', route('feedback.show', [$hashedId]))
            ->with('denyRecommendUrl', route('feedback.show', [$hashedId]))
            ->with('tenant', \Auth::getUser()->tenant);
    }
}

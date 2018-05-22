<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Mail;

class Reminder extends BaseEmailAbstract
{
    public function build()
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

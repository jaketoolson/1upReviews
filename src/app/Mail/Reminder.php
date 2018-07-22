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
        $hashedId = $email->id;

        return $this->view('email')
            ->with('subject', 'test');
    }
}

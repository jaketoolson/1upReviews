<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use Illuminate\Mail\Events\MessageSending;

class MailSending
{
    public function handle(MessageSending $event)
    {
        $event->message->getHeaders()->addTextHeader('X-PM-Metadata-client-id', 1);
    }
}

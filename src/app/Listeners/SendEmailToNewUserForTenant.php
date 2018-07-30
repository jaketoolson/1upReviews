<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use Illuminate\Support\Facades\Mail;
use OneUpReviews\Events\OrganizationAddedUserEvent;
use OneUpReviews\Mail\WelcomeTenantInvitedUser;

class SendEmailToNewUserForTenant
{
    public function handle(OrganizationAddedUserEvent $event)
    {
        Mail::to($event->getNewUser()->getEmail())->send(new WelcomeTenantInvitedUser(
            $event->getNewUser(),
            $event->getInvitedBy(),
            $event->getTemporaryPassword()
        ));
    }
}

<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Mail;

use Illuminate\Mail\Mailable;
use OneUpReviews\Models\User;

/**
 * FIXME: Change the method we are extending to base but adjust the __constructor to be general.
 */
class WelcomeTenantInvitedUser extends Mailable
{
    /**
     * @var User
     */
    private $newUser;

    /**
     * @var User
     */
    private $invitedBy;

    /**
     * @var string
     */
    private $password;
    /**
     * @param User   $newUser
     * @param User   $invitedBy
     * @param string $password
     */
    public function __construct(User $newUser, User $invitedBy, string $password)
    {
        $this->newUser = $newUser;
        $this->invitedBy = $invitedBy;
        $this->password = $password;
    }

    public function build()
    {
        $this->subject(trans('emails.welcome.subject'));

        return $this->view('mail.tenant_welcome_user')
            ->with('subject', $this->subject)
            ->with('password', $this->password)
            ->with('username', $this->newUser->getEmail())
            ->with('tenant', $this->invitedBy->getTenant())
            ->with('invitedBy', $this->invitedBy->getName());
    }
}

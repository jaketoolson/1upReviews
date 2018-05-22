<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

use OneUpReviews\Models\User;

class UserLoggedInEvent
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}

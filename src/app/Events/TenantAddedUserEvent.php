<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

use OneUpReviews\Models\Tenant;
use OneUpReviews\Models\User;

class TenantAddedUserEvent
{
    private $tenant;
    private $newUser;
    private $invitedBy;
    private $temporaryPassword;

    public function __construct(Tenant $tenant, User $newUser, User $invitedBy, string $temporaryPassword)
    {
        $this->tenant = $tenant;
        $this->newUser = $newUser;
        $this->invitedBy = $invitedBy;
        $this->temporaryPassword = $temporaryPassword;
    }

    public function getTenant(): Tenant
    {
        return $this->tenant;
    }

    public function getNewUser(): User
    {
        return $this->newUser;
    }

    public function getInvitedBy(): User
    {
        return $this->invitedBy;
    }

    public function getTemporaryPassword(): string
    {
        return $this->temporaryPassword;
    }
}

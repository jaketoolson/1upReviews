<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

use OneUpReviews\Models\Organization;
use OneUpReviews\Models\User;

class OrganizationAddedUserEvent
{
    private $organization;
    private $newUser;
    private $invitedBy;
    private $temporaryPassword;

    public function __construct(Organization $organization, User $newUser, User $invitedBy, string $temporaryPassword)
    {
        $this->organization = $organization;
        $this->newUser = $newUser;
        $this->invitedBy = $invitedBy;
        $this->temporaryPassword = $temporaryPassword;
    }

    public function getOrganization(): Organization
    {
        return $this->organization;
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

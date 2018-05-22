<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

use OneUpReviews\Models\Tenant;
use OneUpReviews\Models\User;

class TenantAddedUserEvent
{
    /**
     * @var Tenant
     */
    private $tenant;

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
    private $temporaryPassword;

    /**
     * @param Tenant $tenant
     * @param User   $newUser
     * @param User   $invitedBy
     * @param string $temporaryPassword
     */
    public function __construct(Tenant $tenant, User $newUser, User $invitedBy, string $temporaryPassword)
    {
        $this->tenant = $tenant;
        $this->newUser = $newUser;
        $this->invitedBy = $invitedBy;
        $this->temporaryPassword = $temporaryPassword;
    }

    /**
     * @return Tenant
     */
    public function getTenant(): Tenant
    {
        return $this->tenant;
    }

    /**
     * @return User
     */
    public function getNewUser(): User
    {
        return $this->newUser;
    }

    /**
     * @return User
     */
    public function getInvitedBy(): User
    {
        return $this->invitedBy;
    }

    /**
     * @return string
     */
    public function getTemporaryPassword(): string
    {
        return $this->temporaryPassword;
    }
}

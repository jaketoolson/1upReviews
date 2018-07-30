<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

class OrganizationCreatedEvent
{
    private $organizationId;
    private $userId;

    public function __construct(int $organizationId, int $userId)
    {
        $this->organizationId = $organizationId;
        $this->userId = $userId;
    }

    public function getOrganizationId(): int
    {
        return $this->organizationId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}

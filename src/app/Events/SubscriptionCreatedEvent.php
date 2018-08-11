<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

class SubscriptionCreatedEvent
{
    private $organizationId;

    public function __construct(int $organizationId)
    {
        $this->organizationId = $organizationId;
    }

    public function getOrganizationId(): int
    {
        return $this->organizationId;
    }
}

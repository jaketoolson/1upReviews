<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Events;

use OneUpReviews\Models\Tenant;

class TenantCreatingEvent
{
    private $tenant;

    public function __construct(Tenant $tenant)
    {
        $this->tenant = $tenant;
    }

    public function getTenant(): Tenant
    {
        return $this->tenant;
    }
}

<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use OneUpReviews\Events\TenantCreatingEvent;

class SetTenantToGenericTrial
{
    public function handle(TenantCreatingEvent $tenantCreatingEvent): void
    {
        $tenantCreatingEvent->getTenant()->trial_ends_at = now()->addDays(10);
    }
}

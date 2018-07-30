<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Listeners;

use OneUpReviews\Events\OrganizationCreatingEvent;

class SetOrganizationToGenericTrial
{
    public function handle(OrganizationCreatingEvent $organizationCreatingEvent): void
    {
        $organizationCreatingEvent->getOrganization()->trial_ends_at = now()->addDays(10);
    }
}

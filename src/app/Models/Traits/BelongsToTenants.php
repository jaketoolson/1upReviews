<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Models\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use HipsterJazzbo\Landlord\TenantManager;
use HipsterJazzbo\Landlord\BelongsToTenants as BaseBelongsToTenants;

trait BelongsToTenants
{
    use BaseBelongsToTenants;

    public static function bootBelongsToTenants(): void
    {
        if (property_exists(static::class, 'dontBoot')) {
            if (static::$dontBoot === true) {
                static::$booted[] = static::class;
                return;
            }
        }

        static::$landlord = app(TenantManager::class);

        if (Auth::check()) {
            static::$landlord->addTenant('organization_id', Auth::user()->getOrganizationId());
        }

        static::$landlord->applyTenantScopes(new static());

        static::creating(function (Model $model) {
            static::$landlord->newModel($model);
        });
    }
}

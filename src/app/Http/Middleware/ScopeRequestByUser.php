<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use HipsterJazzbo\Landlord\TenantManager;
use HipsterJazzbo\Landlord\Exceptions\TenantNullIdException;

class ScopeRequestByUser
{
    protected $tenantManager;
    protected $guard;

    public function __construct(TenantManager $tenantManager, Guard $guard)
    {
        $this->tenantManager = $tenantManager;
        $this->guard = $guard;
    }

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws TenantNullIdException
     */
    public function handle($request, Closure $next)
    {
        if ($this->guard->check() && $tenantId = $this->guard->user()->getTenantId()) {
//            \Illuminate\Database\Eloquent\Model::clearBootedModels();
            $this->tenantManager->addTenant('tenant_id', $tenantId);
        }

        return $next($request);
    }
}

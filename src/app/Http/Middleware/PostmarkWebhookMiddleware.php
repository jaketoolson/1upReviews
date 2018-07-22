<?php
/**
 * Copyright (c) 2018. Jake Toolson
 */

namespace OneUpReviews\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PostmarkWebhookMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        //TODO: Add Basic Auth
        return $next($request);
    }
}

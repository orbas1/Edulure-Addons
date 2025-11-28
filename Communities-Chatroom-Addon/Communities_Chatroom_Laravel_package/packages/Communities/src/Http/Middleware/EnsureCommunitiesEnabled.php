<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCommunitiesEnabled
{
    public function handle(Request $request, Closure $next)
    {
        if (!config('communities.enabled')) {
            abort(404);
        }

        return $next($request);
    }
}

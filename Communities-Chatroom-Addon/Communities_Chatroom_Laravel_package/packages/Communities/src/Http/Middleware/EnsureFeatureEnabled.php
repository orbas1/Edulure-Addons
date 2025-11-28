<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureFeatureEnabled
{
    public function handle(Request $request, Closure $next, string $feature)
    {
        if (!config('communities.features.' . $feature, false)) {
            abort(404);
        }

        return $next($request);
    }
}

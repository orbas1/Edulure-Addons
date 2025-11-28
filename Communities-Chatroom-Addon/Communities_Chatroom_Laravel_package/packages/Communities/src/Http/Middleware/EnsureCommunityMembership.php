<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RocketAddons\Communities\Models\Channel;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Models\CommunityMember;

class EnsureCommunityMembership
{
    public function handle(Request $request, Closure $next)
    {
        $community = $this->resolveCommunity($request);

        if (!$community) {
            abort(404);
        }

        $membership = CommunityMember::query()
            ->where('community_id', $community->id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$membership || $membership->status === 'banned' || $membership->status === 'pending') {
            abort(403, 'You are not allowed to access this community.');
        }

        $request->attributes->set('communities_membership', $membership);

        return $next($request);
    }

    private function resolveCommunity(Request $request): ?Community
    {
        $route = $request->route();

        $community = $route?->parameter('community');
        if ($community instanceof Community) {
            return $community;
        }

        $channel = $route?->parameter('channel');
        if ($channel instanceof Channel) {
            return $channel->community;
        }

        return null;
    }
}

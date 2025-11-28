<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use RocketAddons\Communities\Models\Channel;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Models\CommunityMember;

class EnsureCommunityCanPost
{
    public function handle(Request $request, Closure $next)
    {
        $membership = $request->attributes->get('communities_membership');

        if (!$membership) {
            $community = $this->resolveCommunity($request);
            if (!$community) {
                abort(404);
            }

            $membership = CommunityMember::query()
                ->where('community_id', $community->id)
                ->where('user_id', $request->user()?->id)
                ->first();
        }

        if (!$membership) {
            abort(403, 'You must be a member to post.');
        }

        if (in_array($membership->status, ['banned', 'muted', 'pending'], true)) {
            abort(403, 'You cannot post in this community.');
        }

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

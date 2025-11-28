<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services;

use Illuminate\Support\Facades\DB;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Models\CommunityMember;
use RocketAddons\Communities\Models\CommunityPricingTier;
use RuntimeException;

class MembershipService
{
    public function joinCommunity(Community $community, int $userId, ?CommunityPricingTier $tier = null): CommunityMember
    {
        if ($tier && !$tier->is_active) {
            throw new RuntimeException('Pricing tier inactive');
        }

        return DB::transaction(function () use ($community, $userId, $tier) {
            $member = CommunityMember::firstOrCreate(
                ['community_id' => $community->id, 'user_id' => $userId],
                [
                    'role_id' => $community->default_role_id,
                    'joined_at' => now(),
                    'status' => 'active',
                ]
            );

            return $member;
        });
    }

    public function leaveCommunity(Community $community, int $userId): void
    {
        CommunityMember::where('community_id', $community->id)
            ->where('user_id', $userId)
            ->delete();
    }
}

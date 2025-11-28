<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services;

use Illuminate\Support\Facades\DB;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Models\CommunityRole;
use RocketAddons\Communities\Models\CommunityMember;

class CommunityManager
{
    public function createCommunity(array $data, int $ownerId): Community
    {
        return DB::transaction(function () use ($data, $ownerId) {
            $community = Community::create(array_merge($data, ['owner_id' => $ownerId]));

            $defaultRole = CommunityRole::firstOrCreate(
                ['community_id' => $community->id, 'slug' => 'member'],
                ['name' => 'Member', 'permissions' => ['post']]
            );

            $community->default_role_id = $defaultRole->id;
            $community->save();

            CommunityMember::create([
                'community_id' => $community->id,
                'user_id' => $ownerId,
                'role_id' => $defaultRole->id,
                'joined_at' => now(),
                'status' => 'active',
            ]);

            return $community;
        });
    }

    public function updateCommunity(Community $community, array $data): Community
    {
        $community->fill($data);
        $community->save();

        return $community;
    }
}

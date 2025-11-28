<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\API;

use Illuminate\Routing\Controller;
use RocketAddons\Communities\Http\Resources\LeaderboardEntryResource;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Models\GamificationProfile;

class LeaderboardController extends Controller
{
    public function show(Community $community)
    {
        $profiles = GamificationProfile::orderByDesc('total_points')->take(50)->get()
            ->map(function ($profile, $index) {
                $profile->rank = $index + 1;
                return $profile;
            });

        return LeaderboardEntryResource::collection($profiles);
    }
}

<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services;

use Illuminate\Support\Facades\DB;
use RocketAddons\Communities\Models\GamificationEvent;
use RocketAddons\Communities\Models\GamificationProfile;

class GamificationService
{
    public function registerEvent(int $userId, string $type, int $points, ?int $communityId = null, array $metadata = []): GamificationEvent
    {
        return DB::transaction(function () use ($userId, $type, $points, $communityId, $metadata) {
            $profile = GamificationProfile::firstOrCreate(['user_id' => $userId]);
            $profile->total_points += $points;
            $profile->xp += $points;
            $profile->last_awarded_at = now();
            $profile->level = $this->resolveLevel($profile->xp);
            $profile->save();

            return GamificationEvent::create([
                'user_id' => $userId,
                'community_id' => $communityId,
                'type' => $type,
                'points' => $points,
                'metadata' => $metadata,
                'occurred_at' => now(),
            ]);
        });
    }

    public function resolveLevel(int $xp): int
    {
        $thresholds = config('communities.gamification.level_thresholds', [0]);
        $level = 1;
        foreach ($thresholds as $index => $threshold) {
            if ($xp >= $threshold) {
                $level = $index + 1;
            }
        }
        return $level;
    }
}

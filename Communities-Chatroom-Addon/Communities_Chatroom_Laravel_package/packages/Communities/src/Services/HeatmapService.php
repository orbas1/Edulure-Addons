<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services;

use RocketAddons\Communities\Models\ActivityHeatmap;

class HeatmapService
{
    public function recordActivity(int $userId, int $communityId): void
    {
        $date = now()->toDateString();
        $hour = (int) now()->format('G');

        $heatmap = ActivityHeatmap::firstOrCreate(
            ['user_id' => $userId, 'community_id' => $communityId, 'date' => $date],
            ['hourly_counts' => array_fill(0, 24, 0)]
        );

        $counts = $heatmap->hourly_counts;
        $counts[$hour] = ($counts[$hour] ?? 0) + 1;
        $heatmap->hourly_counts = $counts;
        $heatmap->save();
    }
}

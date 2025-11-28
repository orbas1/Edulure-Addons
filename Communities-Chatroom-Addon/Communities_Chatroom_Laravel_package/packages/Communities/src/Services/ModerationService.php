<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services;

use RocketAddons\Communities\Models\ModerationReport;
use RocketAddons\Communities\Models\UserModerationAction;

class ModerationService
{
    public function createReport(int $reporterId, string $targetType, int $targetId, string $reason): ModerationReport
    {
        return ModerationReport::create([
            'reporter_id' => $reporterId,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'reason' => $reason,
            'status' => 'open',
        ]);
    }

    public function applyAction(int $userId, string $action, string $reason, ?int $communityId = null, ?int $actorId = null): UserModerationAction
    {
        return UserModerationAction::create([
            'user_id' => $userId,
            'community_id' => $communityId,
            'action' => $action,
            'reason' => $reason,
            'performed_by' => $actorId ?? $userId,
        ]);
    }
}

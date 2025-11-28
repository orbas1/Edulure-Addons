<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeaderboardEntryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user_id' => $this->user_id ?? $this['user_id'] ?? null,
            'points' => $this->points ?? $this['points'] ?? 0,
            'rank' => $this->rank ?? $this['rank'] ?? null,
        ];
    }
}

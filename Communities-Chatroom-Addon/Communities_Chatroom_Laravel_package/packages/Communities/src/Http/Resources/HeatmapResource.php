<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HeatmapResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'user_id' => $this->user_id,
            'community_id' => $this->community_id,
            'date' => $this->date,
            'hourly_counts' => $this->hourly_counts,
        ];
    }
}

<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'community_id' => $this->community_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'type' => $this->type,
            'position' => $this->position,
            'is_private' => (bool) $this->is_private,
            'settings' => $this->settings,
        ];
    }
}

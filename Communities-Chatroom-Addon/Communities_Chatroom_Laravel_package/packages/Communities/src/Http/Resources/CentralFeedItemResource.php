<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CentralFeedItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'community_id' => $this->community_id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'title' => $this->title,
            'content' => $this->content,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at,
        ];
    }
}

<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DMMessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'thread_id' => $this->thread_id,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'metadata' => $this->metadata,
            'created_at' => $this->created_at,
        ];
    }
}

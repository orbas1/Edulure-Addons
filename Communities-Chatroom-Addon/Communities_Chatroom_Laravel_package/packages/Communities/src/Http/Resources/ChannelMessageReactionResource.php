<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelMessageReactionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'emoji' => $this->emoji,
            'user_id' => $this->user_id,
        ];
    }
}

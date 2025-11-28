<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelMessageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'channel_id' => $this->channel_id,
            'user_id' => $this->user_id,
            'content' => $this->content,
            'metadata' => $this->metadata,
            'is_pinned' => (bool) $this->is_pinned,
            'created_at' => $this->created_at,
            'attachments' => ChannelMessageAttachmentResource::collection($this->whenLoaded('attachments')),
            'reactions' => ChannelMessageReactionResource::collection($this->whenLoaded('reactions')),
        ];
    }
}

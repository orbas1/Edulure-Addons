<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChannelMessageAttachmentResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'path' => $this->path,
            'original_name' => $this->original_name,
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'scan_status' => $this->scan_status,
        ];
    }
}

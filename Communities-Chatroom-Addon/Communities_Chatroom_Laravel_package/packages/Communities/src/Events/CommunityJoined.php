<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use RocketAddons\Communities\Models\CommunityMember;

class CommunityJoined
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public CommunityMember $membership)
    {
    }
}

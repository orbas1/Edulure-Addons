<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use RocketAddons\Communities\Models\UserModerationAction;

class UserBannedInCommunity
{
    use Dispatchable, SerializesModels;

    public function __construct(public UserModerationAction $action)
    {
    }
}

<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Policies;

use App\Models\User;
use RocketAddons\Communities\Models\Channel;

class ChannelPolicy
{
    public function view(User $user, Channel $channel): bool
    {
        return true;
    }

    public function post(User $user, Channel $channel): bool
    {
        return true;
    }
}

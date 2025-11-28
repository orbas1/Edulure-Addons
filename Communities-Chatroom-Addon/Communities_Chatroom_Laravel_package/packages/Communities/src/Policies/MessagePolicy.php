<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Policies;

use App\Models\User;
use RocketAddons\Communities\Models\ChannelMessage;

class MessagePolicy
{
    public function update(User $user, ChannelMessage $message): bool
    {
        return $message->user_id === $user->id;
    }
}

<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Policies;

use RocketAddons\Communities\Models\Community;
use App\Models\User;

class CommunityPolicy
{
    public function view(User $user, Community $community): bool
    {
        return true;
    }

    public function update(User $user, Community $community): bool
    {
        return $community->owner_id === $user->id;
    }
}

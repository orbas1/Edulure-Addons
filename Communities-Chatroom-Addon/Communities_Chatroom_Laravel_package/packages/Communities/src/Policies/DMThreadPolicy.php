<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Policies;

use App\Models\User;
use RocketAddons\Communities\Models\DMThread;

class DMThreadPolicy
{
    public function view(User $user, DMThread $thread): bool
    {
        return $thread->participants()->where('user_id', $user->id)->exists();
    }
}

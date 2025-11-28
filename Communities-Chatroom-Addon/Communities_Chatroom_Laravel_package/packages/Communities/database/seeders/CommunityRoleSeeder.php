<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Database\Seeders;

use Illuminate\Database\Seeder;
use RocketAddons\Communities\Models\CommunityRole;

class CommunityRoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Owner', 'slug' => 'owner', 'permissions' => ['*']],
            ['name' => 'Moderator', 'slug' => 'moderator', 'permissions' => ['manage_channels', 'moderate', 'post']],
            ['name' => 'Member', 'slug' => 'member', 'permissions' => ['post']],
            ['name' => 'Guest', 'slug' => 'guest', 'permissions' => []],
        ];

        foreach ($roles as $role) {
            CommunityRole::firstOrCreate(
                ['community_id' => null, 'slug' => $role['slug']],
                ['name' => $role['name'], 'permissions' => $role['permissions']]
            );
        }
    }
}

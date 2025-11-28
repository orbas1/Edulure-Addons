<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Services;

use Illuminate\Support\Facades\DB;
use RocketAddons\Communities\Models\Channel;
use RocketAddons\Communities\Models\Community;

class ChannelService
{
    public function createChannel(Community $community, array $data): Channel
    {
        return DB::transaction(fn () => $community->channels()->create($data));
    }

    public function updateChannel(Channel $channel, array $data): Channel
    {
        $channel->fill($data);
        $channel->save();
        return $channel;
    }
}

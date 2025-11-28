<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Events;

use Illuminate\Broadcasting\Channel as BroadcastChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use RocketAddons\Communities\Models\ChannelMessage;

class ChannelMessagePosted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public ChannelMessage $message)
    {
    }

    public function broadcastOn(): BroadcastChannel
    {
        return new BroadcastChannel(config('communities.chat.broadcast_prefix') . '.channel.' . $this->message->channel_id);
    }
}

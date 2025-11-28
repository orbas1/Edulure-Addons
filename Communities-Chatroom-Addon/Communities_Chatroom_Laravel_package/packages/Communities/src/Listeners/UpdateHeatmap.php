<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Listeners;

use RocketAddons\Communities\Events\ChannelMessagePosted;
use RocketAddons\Communities\Events\DMMessagePosted;
use RocketAddons\Communities\Services\HeatmapService;

class UpdateHeatmap
{
    public function __construct(private HeatmapService $heatmap)
    {
    }

    public function handleChannel(ChannelMessagePosted $event): void
    {
        $this->heatmap->recordActivity($event->message->user_id, $event->message->channel->community_id);
    }

    public function handleDm(DMMessagePosted $event): void
    {
        // DM messages are not tied to community; skip or set community_id null
    }
}

<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\Web;

use Illuminate\Http\Request;
use Illuminate\View\View;
use RocketAddons\Communities\Http\Controllers\Controller;
use RocketAddons\Communities\Models\Channel;
use RocketAddons\Communities\Models\Community;
use RocketAddons\Communities\Policies\ChannelPolicy;

class ChannelPageController extends Controller
{
    public function show(Request $request, Community $community, Channel $channel): View
    {
        $this->authorize('view', $channel);

        $channels = Channel::where('community_id', $community->id)
            ->orderBy('position')
            ->get()
            ->groupBy(fn($item) => $item->parent_id ? optional($item->parent)->name : __('communities::communities.general'))
            ->map(fn($group, $category) => ['category' => $category, 'items' => $group]);

        $messages = $channel->messages()->with(['user', 'reactions'])->latest()->limit(50)->get()->reverse();

        return view('addons.communities.channels.show', compact('community', 'channel', 'channels', 'messages'));
    }
}

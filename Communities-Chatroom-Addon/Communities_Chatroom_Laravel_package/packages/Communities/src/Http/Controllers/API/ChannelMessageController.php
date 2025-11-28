<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\API;

use Illuminate\Routing\Controller;
use RocketAddons\Communities\Http\Requests\StoreChannelMessageRequest;
use RocketAddons\Communities\Http\Resources\ChannelMessageResource;
use RocketAddons\Communities\Models\Channel;
use RocketAddons\Communities\Models\ChannelMessage;
use RocketAddons\Communities\Services\ChatService;

class ChannelMessageController extends Controller
{
    public function __construct(private ChatService $chatService)
    {
        $this->middleware('auth');
    }

    public function index(Channel $channel)
    {
        $messages = $channel->messages()->with(['attachments', 'reactions'])->latest()->paginate();
        return ChannelMessageResource::collection($messages);
    }

    public function store(StoreChannelMessageRequest $request, Channel $channel)
    {
        $message = $this->chatService->postMessage($channel, $request->user()->id, $request->validated());
        return new ChannelMessageResource($message->load(['attachments', 'reactions']));
    }

    public function react(Channel $channel, ChannelMessage $message)
    {
        $reaction = $this->chatService->react($message, request()->user()->id, request()->input('emoji', 'like'));
        return response()->json(['status' => 'ok', 'reaction_id' => $reaction->id]);
    }
}

<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\API;

use Illuminate\Routing\Controller;
use RocketAddons\Communities\Http\Requests\StoreDMMessageRequest;
use RocketAddons\Communities\Http\Requests\StoreDMThreadRequest;
use RocketAddons\Communities\Http\Resources\DMMessageResource;
use RocketAddons\Communities\Http\Resources\DMThreadResource;
use RocketAddons\Communities\Models\DMThread;
use RocketAddons\Communities\Services\DMService;

class DMController extends Controller
{
    public function __construct(private DMService $dmService)
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $threads = DMThread::whereHas('participants', fn ($q) => $q->where('user_id', request()->user()->id))
            ->with('participants')
            ->paginate();

        return DMThreadResource::collection($threads);
    }

    public function store(StoreDMThreadRequest $request)
    {
        $thread = $this->dmService->createThread(
            $request->user()->id,
            $request->input('participants', []),
            $request->input('type', 'dm'),
            $request->input('title')
        );

        return new DMThreadResource($thread->load('participants'));
    }

    public function messages(DMThread $thread)
    {
        $messages = $thread->messages()->latest()->paginate();
        return DMMessageResource::collection($messages);
    }

    public function storeMessage(StoreDMMessageRequest $request, DMThread $thread)
    {
        $message = $this->dmService->postMessage($thread, $request->user()->id, $request->validated());
        return new DMMessageResource($message);
    }
}

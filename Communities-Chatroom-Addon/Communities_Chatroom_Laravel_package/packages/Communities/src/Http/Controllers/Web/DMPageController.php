<?php

declare(strict_types=1);

namespace RocketAddons\Communities\Http\Controllers\Web;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RocketAddons\Communities\Http\Controllers\Controller;
use RocketAddons\Communities\Models\DMThread;
use RocketAddons\Communities\Services\DMService;

class DMPageController extends Controller
{
    public function __construct(private readonly DMService $dmService)
    {
    }

    public function index(Request $request): View
    {
        $threads = DMThread::with(['participants.user', 'lastMessage'])
            ->whereHas('participants', fn($q) => $q->where('user_id', $request->user()->id))
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('addons.communities.dm.index', compact('threads'));
    }

    public function show(Request $request, DMThread $thread): View
    {
        $this->authorize('view', $thread);

        $threads = DMThread::with(['participants.user', 'lastMessage'])
            ->whereHas('participants', fn($q) => $q->where('user_id', $request->user()->id))
            ->orderByDesc('last_message_at')
            ->get();

        $messages = $thread->messages()->with('user')->latest()->limit(50)->get()->reverse();

        return view('addons.communities.dm.show', compact('thread', 'threads', 'messages'));
    }

    public function create(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'participants' => ['required', 'string'],
            'title' => ['nullable', 'string'],
        ]);

        $participants = array_filter(array_map('trim', explode(',', $data['participants'])));

        $thread = $this->dmService->createThread($request->user(), [
            'participants' => $participants,
            'title' => $data['title'] ?? null,
        ]);

        return redirect()->route('dm.show', $thread);
    }
}

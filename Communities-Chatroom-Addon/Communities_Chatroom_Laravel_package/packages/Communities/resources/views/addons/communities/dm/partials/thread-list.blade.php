<div class="list-group dm-thread-list">
    @foreach($threads as $dm)
        <a href="{{ route('dm.show', $dm) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center @if(isset($thread) && $thread->id === $dm->id) active @endif">
            <div>
                <div class="fw-semibold">{{ $dm->title ?? $dm->participants->pluck('user.name')->join(', ') }}</div>
                <div class="text-muted small">{{ optional($dm->lastMessage)->content ? Str::limit($dm->lastMessage->content, 40) : __('communities::communities.no_messages') }}</div>
            </div>
            <span class="tiny text-muted">{{ optional($dm->last_message_at)->diffForHumans() }}</span>
        </a>
    @endforeach
</div>

<div class="feed-comment d-flex gap-2">
    <img src="{{ $comment->user->avatar ?? 'https://www.gravatar.com/avatar/' . md5($comment->user->email) }}" class="rounded-circle" width="28" height="28" alt="{{ $comment->user->name }}">
    <div>
        <div class="fw-semibold small">{{ $comment->user->name }}</div>
        <div class="text-muted tiny">{{ $comment->created_at->diffForHumans() }}</div>
        <div>{!! nl2br(e($comment->content)) !!}</div>
    </div>
</div>

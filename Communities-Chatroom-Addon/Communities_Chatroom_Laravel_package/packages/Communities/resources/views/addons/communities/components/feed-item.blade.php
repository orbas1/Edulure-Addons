<article class="feed-item" data-feed-id="{{ $item->id }}">
    <div class="feed-item__header d-flex align-items-center gap-2">
        <img src="{{ $item->user->avatar ?? 'https://www.gravatar.com/avatar/' . md5($item->user->email) }}" class="rounded-circle" width="32" height="32" alt="{{ $item->user->name }}">
        <div>
            <div class="fw-semibold">{{ $item->user->name }}</div>
            <div class="text-muted small">{{ $item->created_at->diffForHumans() }}</div>
        </div>
    </div>
    @if($item->title)
        <h5 class="mt-2">{{ $item->title }}</h5>
    @endif
    <div class="feed-item__content">{!! nl2br(e($item->content)) !!}</div>
    <div class="feed-item__actions d-flex align-items-center gap-3 mt-2">
        <button class="btn btn-sm btn-light js-react" data-reaction="like">👍 <span class="count">{{ $item->reactions_count ?? $item->reactions()->count() }}</span></button>
        <button class="btn btn-sm btn-light js-toggle-comments">{{ __('communities::communities.comments') }} ({{ $item->comments_count ?? $item->comments()->count() }})</button>
    </div>
    <div class="feed-item__comments mt-2 d-none">
        @foreach($item->comments as $comment)
            @include('addons.communities.components.feed-comment', ['comment' => $comment])
        @endforeach
        <form class="feed-comment-form mt-2" data-feed-id="{{ $item->id }}">
            @csrf
            <textarea class="form-control" rows="2" name="content" placeholder="{{ __('communities::communities.add_comment') }}" required></textarea>
            <button class="btn btn-primary btn-sm mt-1">{{ __('communities::communities.post_comment') }}</button>
        </form>
    </div>
</article>

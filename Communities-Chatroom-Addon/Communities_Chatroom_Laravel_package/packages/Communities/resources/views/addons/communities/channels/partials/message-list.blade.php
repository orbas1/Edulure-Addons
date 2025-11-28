<div id="channel-message-list" class="channel-messages" data-fetch="{{ route('api.channels.messages.index', $channel) }}" data-react="{{ route('api.channels.messages.react', [$channel, 0]) }}">
    @foreach($messages as $message)
        <div class="channel-message" data-message-id="{{ $message->id }}">
            <div class="channel-message__avatar">
                <img src="{{ $message->user->avatar ?? 'https://www.gravatar.com/avatar/' . md5($message->user->email) }}" class="rounded-circle" width="36" height="36" alt="{{ $message->user->name }}">
            </div>
            <div class="channel-message__body">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-semibold">{{ $message->user->name }}</span>
                    <span class="text-muted tiny">{{ $message->created_at->format('H:i') }}</span>
                    @if($message->created_at != $message->updated_at)
                        <span class="text-muted tiny">{{ __('communities::communities.edited') }}</span>
                    @endif
                </div>
                <div class="channel-message__content">{!! nl2br(e($message->content)) !!}</div>
                <div class="channel-message__reactions d-flex gap-2 mt-1">
                    @foreach($message->reactions as $reaction)
                        <span class="badge bg-light text-dark">{{ $reaction->emoji }} {{ $reaction->count ?? 1 }}</span>
                    @endforeach
                    <button class="btn btn-sm btn-light js-react" data-emoji="👍">👍</button>
                </div>
            </div>
        </div>
    @endforeach
</div>

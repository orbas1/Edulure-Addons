<div class="channel-groups">
    @foreach($channels as $channel)
        <div class="channel-row d-flex align-items-center justify-content-between">
            <div>
                @include('addons.communities.components.channel-badge', ['channel' => $channel])
                <span class="text-muted small">{{ $channel->type }}</span>
            </div>
            <a href="{{ route('communities.channels.show', [$community, $channel]) }}" class="btn btn-sm btn-outline-primary">{{ __('communities::communities.open') }}</a>
        </div>
    @endforeach
</div>

@extends('addons.communities.layouts.base')

@section('communities-content')
<div class="channel-layout">
    <aside class="channel-sidebar">
        <div class="p-3 border-bottom">
            <h5 class="mb-0">{{ $community->name }}</h5>
            <small class="text-muted">{{ __('communities::communities.channels') }}</small>
        </div>
        <div class="channel-sidebar__list">
            @foreach($channels as $grouped)
                <div class="channel-sidebar__section">
                    <div class="text-muted small px-3 py-2">{{ $grouped['category'] ?? __('communities::communities.general') }}</div>
                    @foreach($grouped['items'] as $item)
                        <a href="{{ route('communities.channels.show', [$community, $item]) }}" class="channel-sidebar__item @if($item->id === $channel->id) active @endif">
                            #{{ $item->name }}
                            @if($item->is_private)
                                <i class="bi bi-lock-fill ms-1"></i>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </aside>
    <main class="channel-main" data-channel-id="{{ $channel->id }}">
        <div class="channel-main__header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">#{{ $channel->name }}</h4>
                <small class="text-muted">{{ $channel->type }}</small>
            </div>
        </div>
        @include('addons.communities.channels.partials.message-list')
        @include('addons.communities.channels.partials.message-composer')
    </main>
</div>
@endsection

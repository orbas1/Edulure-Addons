@extends('addons.communities.layouts.base')

@section('communities-content')
<div class="channel-layout">
    <aside class="channel-sidebar">
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="mb-0">{{ __('communities::communities.messages') }}</h5>
            <a href="{{ route('dm.index') }}" class="btn btn-sm btn-outline-secondary">{{ __('communities::communities.inbox') }}</a>
        </div>
        @include('addons.communities.dm.partials.thread-list')
    </aside>
    <main class="channel-main" data-thread-id="{{ $thread->id }}">
        <div class="channel-main__header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="mb-0">{{ $thread->title ?? $thread->participants->pluck('user.name')->join(', ') }}</h4>
                <small class="text-muted">{{ $thread->type }}</small>
            </div>
        </div>
        <div id="dm-message-list" class="channel-messages" data-fetch="{{ route('api.dm.messages.index', $thread) }}">
            @foreach($messages as $message)
                <div class="channel-message" data-message-id="{{ $message->id }}">
                    <div class="channel-message__avatar"><img src="{{ $message->user->avatar ?? '' }}" class="rounded-circle" width="36" height="36"></div>
                    <div class="channel-message__body">
                        <div class="d-flex align-items-center gap-2">
                            <span class="fw-semibold">{{ $message->user->name }}</span>
                            <span class="text-muted tiny">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                        <div class="channel-message__content">{!! nl2br(e($message->content)) !!}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="channel-composer">
            <form id="dm-message-form" data-endpoint="{{ route('api.dm.messages.store', $thread) }}">
                @csrf
                <div class="input-group">
                    <textarea class="form-control" rows="2" name="content" placeholder="{{ __('communities::communities.message_placeholder') }}" required></textarea>
                    <button class="btn btn-primary" type="submit">{{ __('communities::communities.send') }}</button>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection

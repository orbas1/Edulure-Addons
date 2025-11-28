<div class="channel-composer">
    <form id="channel-message-form" data-endpoint="{{ route('api.channels.messages.store', $channel) }}">
        @csrf
        <div class="input-group">
            <textarea class="form-control" rows="2" name="content" placeholder="{{ __('communities::communities.message_placeholder') }}" required></textarea>
            <button class="btn btn-primary" type="submit">{{ __('communities::communities.send') }}</button>
        </div>
        <div class="d-flex gap-2 mt-1">
            <label class="btn btn-sm btn-outline-secondary mb-0">
                {{ __('communities::communities.attach') }}
                <input type="file" name="attachment" class="d-none">
            </label>
            <button class="btn btn-sm btn-outline-light js-emoji" type="button">😊</button>
        </div>
    </form>
</div>

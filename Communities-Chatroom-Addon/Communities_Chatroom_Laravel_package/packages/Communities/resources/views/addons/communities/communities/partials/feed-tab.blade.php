<div class="feed-composer card mb-3">
    <div class="card-body">
        <form id="feed-composer-form" data-community-id="{{ $community->id }}">
            @csrf
            <textarea class="form-control" name="content" rows="3" placeholder="{{ __('communities::communities.share_update') }}" required></textarea>
            <div class="d-flex justify-content-between align-items-center mt-2">
                <div class="d-flex gap-2 align-items-center">
                    <label class="btn btn-sm btn-outline-secondary mb-0">
                        {{ __('communities::communities.add_attachment') }}
                        <input type="file" name="attachment" class="d-none">
                    </label>
                </div>
                <button class="btn btn-primary btn-sm">{{ __('communities::communities.post') }}</button>
            </div>
        </form>
    </div>
</div>
<div id="feed-list" data-next="{{ $feedItems->nextPageUrl() }}">
    @foreach($feedItems as $item)
        @include('addons.communities.components.feed-item', ['item' => $item])
    @endforeach
    @include('addons.communities.components.pagination', ['paginator' => $feedItems])
</div>

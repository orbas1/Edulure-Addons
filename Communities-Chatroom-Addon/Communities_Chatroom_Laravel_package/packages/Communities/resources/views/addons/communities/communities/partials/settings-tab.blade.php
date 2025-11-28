@can('update', $community)
<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ __('communities::communities.manage_settings') }}</h5>
        <form method="post" action="{{ route('communities.update', $community) }}">
            @csrf
            @method('put')
            <div class="mb-2">
                <label class="form-label">{{ __('communities::communities.name') }}</label>
                <input type="text" class="form-control" name="name" value="{{ old('name', $community->name) }}">
            </div>
            <div class="mb-2">
                <label class="form-label">{{ __('communities::communities.description') }}</label>
                <textarea class="form-control" name="description" rows="3">{{ old('description', $community->description) }}</textarea>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" value="1" name="is_private" id="is_private" @checked($community->is_private)>
                <label class="form-check-label" for="is_private">{{ __('communities::communities.private') }}</label>
            </div>
            <button class="btn btn-primary">{{ __('communities::communities.save') }}</button>
        </form>
    </div>
</div>
@endcan

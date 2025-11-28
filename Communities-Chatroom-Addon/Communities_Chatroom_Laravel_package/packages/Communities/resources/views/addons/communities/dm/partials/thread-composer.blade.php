<div class="modal fade" id="newDmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('communities::communities.new_dm') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="dm-thread-form" data-endpoint="{{ route('api.dm.threads.store') }}">
                    @csrf
                    <div class="mb-2">
                        <label class="form-label">{{ __('communities::communities.participants') }}</label>
                        <input type="text" class="form-control" name="participants" placeholder="user ids comma separated">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">{{ __('communities::communities.title_optional') }}</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <button class="btn btn-primary">{{ __('communities::communities.start') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="member-list">
    @foreach($members as $member)
        <div class="member-list__item d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ $member->user->avatar ?? 'https://www.gravatar.com/avatar/' . md5($member->user->email) }}" alt="{{ $member->user->name }}" class="rounded-circle" width="32" height="32">
                <div>
                    <div class="fw-semibold">{{ $member->user->name }}</div>
                    <div class="text-muted small">{{ optional($member->role)->name }}</div>
                </div>
            </div>
            <span class="badge bg-light text-dark">{{ __('communities::communities.status_' . $member->status) }}</span>
        </div>
    @endforeach
</div>

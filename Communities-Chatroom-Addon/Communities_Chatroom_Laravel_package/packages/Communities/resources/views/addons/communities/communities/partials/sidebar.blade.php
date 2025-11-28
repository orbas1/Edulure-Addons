<div class="community-sidebar card">
    <div class="card-body">
        <h5 class="card-title">{{ __('communities::communities.about') }}</h5>
        <p class="text-muted">{{ $community->description }}</p>
        <div class="mb-2">
            <div class="fw-semibold">{{ __('communities::communities.owner') }}</div>
            <div>{{ optional($community->owner)->name }}</div>
        </div>
        <div class="mb-2">
            <div class="fw-semibold">{{ __('communities::communities.moderators') }}</div>
            <div class="small text-muted">{{ $moderators->pluck('user.name')->join(', ') }}</div>
        </div>
        <div class="mb-2">
            <div class="fw-semibold">{{ __('communities::communities.my_status') }}</div>
            <div class="small text-muted">{{ optional($membership->role)->name ?? __('communities::communities.guest') }}</div>
            @if($subscription)
                <div class="small">{{ __('communities::communities.tier') }}: {{ optional($subscription->pricingTier)->name }} ({{ optional($subscription->expires_at)->toFormattedDateString() }})</div>
            @endif
        </div>
        <div class="d-flex flex-column gap-2">
            <a href="{{ route('dm.create', ['user' => $community->owner_id]) }}" class="btn btn-outline-secondary btn-sm">{{ __('communities::communities.dm_owner') }}</a>
            <a href="#" class="btn btn-outline-light btn-sm">{{ __('communities::communities.view_rules') }}</a>
        </div>
    </div>
</div>

<div class="community-card" data-community-id="{{ $community->id }}">
    <div class="community-card__header">
        <div>
            <h3 class="community-card__title">{{ $community->name }}</h3>
            <p class="community-card__subtitle text-muted">{{ Str::limit($community->description, 120) }}</p>
        </div>
        <div class="community-card__status">
            @if(optional($community->pricingTiers->firstWhere('is_default', true))->price)
                <span class="badge bg-primary">{{ __('communities::communities.paid') }}</span>
            @else
                <span class="badge bg-success">{{ __('communities::communities.free') }}</span>
            @endif
        </div>
    </div>
    <div class="community-card__meta">
        <span class="community-card__meta-item">{{ __('communities::communities.owner') }}: {{ optional($community->owner)->name }}</span>
        <span class="community-card__meta-item">{{ __('communities::communities.members') }}: {{ $community->members_count ?? $community->members()->count() }}</span>
        @if($community->is_private ?? false)
            <span class="badge bg-warning">{{ __('communities::communities.private') }}</span>
        @else
            <span class="badge bg-info">{{ __('communities::communities.public') }}</span>
        @endif
    </div>
    <div class="community-card__actions d-flex gap-2 mt-2">
        <a href="{{ route('communities.show', $community) }}" class="btn btn-sm btn-outline-primary">{{ __('communities::communities.view') }}</a>
        @if(isset($showJoin) && $showJoin)
            <form method="post" action="{{ route('communities.join', $community) }}">
                @csrf
                <button class="btn btn-sm btn-primary">{{ __('communities::communities.join') }}</button>
            </form>
        @endif
    </div>
</div>

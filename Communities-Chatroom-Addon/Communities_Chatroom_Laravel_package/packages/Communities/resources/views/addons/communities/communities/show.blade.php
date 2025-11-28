@extends('addons.communities.layouts.base')

@section('communities-content')
<div class="community-header d-flex justify-content-between align-items-center mb-3">
    <div>
        <h1 class="mb-0">{{ $community->name }}</h1>
        <p class="text-muted">{{ $community->description }}</p>
        <div class="d-flex gap-2">
            <span class="badge bg-light text-dark">{{ __('communities::communities.members') }}: {{ $community->members_count ?? $community->members()->count() }}</span>
            <span class="badge bg-secondary">{{ optional($membership->role)->name ?? __('communities::communities.guest') }}</span>
        </div>
    </div>
    <div class="d-flex gap-2">
        @if(!$membership)
            <form method="post" action="{{ route('communities.join', $community) }}">@csrf<button class="btn btn-primary">{{ __('communities::communities.join') }}</button></form>
        @else
            <form method="post" action="{{ route('communities.leave', $community) }}">@csrf<button class="btn btn-outline-danger">{{ __('communities::communities.leave') }}</button></form>
        @endif
        @if(isset($pricingTiers) && $pricingTiers->count())
            <a href="#pricing" class="btn btn-outline-primary">{{ __('communities::communities.upgrade') }}</a>
        @endif
    </div>
</div>
@include('addons.communities.communities.partials.tabs')
<div class="row mt-3">
    <div class="col-lg-8">
        @includeWhen($activeTab === 'feed', 'addons.communities.communities.partials.feed-tab')
        @includeWhen($activeTab === 'channels', 'addons.communities.communities.partials.channels-tab')
        @includeWhen($activeTab === 'members', 'addons.communities.communities.partials.members-tab')
        @includeWhen($activeTab === 'courses', 'addons.communities.communities.partials.courses-tab')
        @includeWhen($activeTab === 'leaderboard', 'addons.communities.communities.partials.leaderboard-tab')
        @includeWhen($activeTab === 'settings', 'addons.communities.communities.partials.settings-tab')
    </div>
    <div class="col-lg-4">
        @include('addons.communities.communities.partials.sidebar')
    </div>
</div>
@if(isset($pricingTiers) && $pricingTiers->count())
<div class="row mt-4" id="pricing">
    <h3>{{ __('communities::communities.pricing_tiers') }}</h3>
    @foreach($pricingTiers as $tier)
        <div class="col-md-4">
            @include('addons.communities.components.pricing-tier-card', ['tier' => $tier, 'community' => $community])
        </div>
    @endforeach
</div>
@endif
@endsection

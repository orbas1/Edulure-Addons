@extends('addons.communities.layouts.base')

@section('communities-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>{{ __('communities::communities.all_communities') }}</h1>
    <form method="get" class="d-flex gap-2">
        <select name="visibility" class="form-select form-select-sm">
            <option value="">{{ __('communities::communities.filter_all') }}</option>
            <option value="public" @selected(request('visibility')==='public')>{{ __('communities::communities.public') }}</option>
            <option value="private" @selected(request('visibility')==='private')>{{ __('communities::communities.private') }}</option>
        </select>
        <select name="membership" class="form-select form-select-sm">
            <option value="">{{ __('communities::communities.filter_membership') }}</option>
            <option value="joined" @selected(request('membership')==='joined')>{{ __('communities::communities.joined') }}</option>
            <option value="not_joined" @selected(request('membership')==='not_joined')>{{ __('communities::communities.not_joined') }}</option>
        </select>
        <select name="pricing" class="form-select form-select-sm">
            <option value="">{{ __('communities::communities.filter_pricing') }}</option>
            <option value="free" @selected(request('pricing')==='free')>{{ __('communities::communities.free') }}</option>
            <option value="paid" @selected(request('pricing')==='paid')>{{ __('communities::communities.paid') }}</option>
        </select>
        <select name="sort" class="form-select form-select-sm">
            <option value="newest" @selected(request('sort')==='newest')>{{ __('communities::communities.sort_newest') }}</option>
            <option value="active" @selected(request('sort')==='active')>{{ __('communities::communities.sort_active') }}</option>
        </select>
        <button class="btn btn-primary btn-sm">{{ __('communities::communities.apply') }}</button>
    </form>
</div>
<div class="row g-3">
    @foreach($communities as $community)
        <div class="col-md-4">
            @include('addons.communities.components.community-card', ['community' => $community, 'showJoin' => true])
        </div>
    @endforeach
</div>
<div class="mt-3">
    @include('addons.communities.components.pagination', ['paginator' => $communities])
</div>
@endsection

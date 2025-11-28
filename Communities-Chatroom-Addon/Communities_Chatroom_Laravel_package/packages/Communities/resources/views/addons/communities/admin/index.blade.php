@extends('addons.communities.layouts.base')

@section('communities-content')
<div class="row g-3">
    <div class="col-md-3">
        <a href="{{ route('communities.admin.settings') }}" class="card h-100 text-decoration-none">
            <div class="card-body">
                <h5 class="card-title">{{ __('communities::communities.admin_settings') }}</h5>
                <p class="text-muted">{{ __('communities::communities.admin_settings_desc') }}</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('communities.admin.communities') }}" class="card h-100 text-decoration-none">
            <div class="card-body">
                <h5 class="card-title">{{ __('communities::communities.admin_communities') }}</h5>
                <p class="text-muted">{{ __('communities::communities.admin_communities_desc') }}</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('communities.admin.moderation') }}" class="card h-100 text-decoration-none">
            <div class="card-body">
                <h5 class="card-title">{{ __('communities::communities.admin_moderation') }}</h5>
                <p class="text-muted">{{ __('communities::communities.admin_moderation_desc') }}</p>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('communities.admin.gamification') }}" class="card h-100 text-decoration-none">
            <div class="card-body">
                <h5 class="card-title">{{ __('communities::communities.admin_gamification') }}</h5>
                <p class="text-muted">{{ __('communities::communities.admin_gamification_desc') }}</p>
            </div>
        </a>
    </div>
</div>
@endsection

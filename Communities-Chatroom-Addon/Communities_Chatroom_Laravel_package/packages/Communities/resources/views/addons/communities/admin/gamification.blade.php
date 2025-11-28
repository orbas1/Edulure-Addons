@extends('addons.communities.layouts.base')

@section('communities-content')
<h3>{{ __('communities::communities.admin_gamification') }}</h3>
<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title">{{ __('communities::communities.top_users') }}</h5>
                <ul class="list-group list-group-flush">
                    @foreach($topUsers as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $user->user->name }}</span>
                            <span class="badge bg-primary">{{ $user->points }} {{ __('communities::communities.points') }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <form method="post" action="{{ route('communities.admin.gamification.save') }}" class="card h-100">
            @csrf
            <div class="card-body">
                <h5 class="card-title">{{ __('communities::communities.level_thresholds') }}</h5>
                <textarea class="form-control" rows="8" name="levels">{{ json_encode($levels, JSON_PRETTY_PRINT) }}</textarea>
                <button class="btn btn-primary mt-3">{{ __('communities::communities.save') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

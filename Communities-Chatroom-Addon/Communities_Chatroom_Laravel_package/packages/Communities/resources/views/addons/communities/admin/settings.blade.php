@extends('addons.communities.layouts.base')

@section('communities-content')
<h3>{{ __('communities::communities.admin_settings') }}</h3>
<form method="post" action="{{ route('communities.admin.settings.save') }}" class="card p-3">
    @csrf
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">{{ __('communities::communities.enable_leaderboard') }}</label>
            <input type="checkbox" name="features[leaderboard]" value="1" @checked($config['features']['leaderboard'] ?? false)>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ __('communities::communities.enable_dm') }}</label>
            <input type="checkbox" name="features[dm]" value="1" @checked($config['features']['dm'] ?? false)>
        </div>
        <div class="col-md-4">
            <label class="form-label">{{ __('communities::communities.enable_chatroom') }}</label>
            <input type="checkbox" name="features[chatroom]" value="1" @checked($config['features']['chatroom'] ?? false)>
        </div>
    </div>
    <div class="mt-3">
        <label class="form-label">{{ __('communities::communities.file_scanner') }}</label>
        <select name="file_scanner[driver]" class="form-select">
            <option value="null" @selected(($config['file_scanner']['driver'] ?? '')==='null')>Null</option>
            <option value="clamav" @selected(($config['file_scanner']['driver'] ?? '')==='clamav')>ClamAV</option>
            <option value="http" @selected(($config['file_scanner']['driver'] ?? '')==='http')>HTTP</option>
        </select>
    </div>
    <div class="mt-3">
        <label class="form-label">{{ __('communities::communities.gamification_points') }}</label>
        <textarea class="form-control" rows="4" name="gamification_points">{{ json_encode($config['gamification']['points'] ?? [], JSON_PRETTY_PRINT) }}</textarea>
    </div>
    <button class="btn btn-primary mt-3">{{ __('communities::communities.save') }}</button>
</form>
@endsection

@extends('addons.communities.layouts.base')

@section('communities-content')
<h3>{{ __('communities::communities.user_heatmap') }}</h3>
<div id="heatmap" class="heatmap-grid" data-endpoint="{{ route('api.users.heatmap', $user) }}"></div>
@endsection

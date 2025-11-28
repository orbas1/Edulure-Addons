@extends('addons.communities.layouts.base')

@section('communities-content')
<h3>{{ __('communities::communities.community_heatmap') }}</h3>
<div id="heatmap" class="heatmap-grid" data-endpoint="{{ route('api.users.heatmap', $community->owner_id ?? auth()->id()) }}"></div>
@endsection

@extends('addons.communities.layouts.base')

@section('communities-content')
<h2>{{ __('communities::communities.leaderboard') }}</h2>
@include('addons.communities.leaderboard.partials.leaderboard-table', ['entries' => $entries])
@endsection

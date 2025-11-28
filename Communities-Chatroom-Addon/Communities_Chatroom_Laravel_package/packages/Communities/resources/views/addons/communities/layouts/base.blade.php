@extends('layouts.app')

@section('title', __('communities::communities.title'))

@section('content')
<div class="communities-wrapper">
    <div class="container">
        @yield('communities-content')
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/communities/css/communities.css') }}">
@endpush

@push('scripts')
    <script>
        window.communitiesBroadcastPrefix = @json(config('communities.chat.broadcast_prefix', 'communities'));
    </script>
    <script src="{{ asset('vendor/communities/js/communities.js') }}"></script>
@endpush

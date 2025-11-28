@extends('addons.communities.layouts.base')

@section('communities-content')
<div class="dm-layout">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>{{ __('communities::communities.direct_messages') }}</h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newDmModal">{{ __('communities::communities.new_dm') }}</button>
    </div>
    @include('addons.communities.dm.partials.thread-list')
</div>
@include('addons.communities.dm.partials.thread-composer')
@endsection

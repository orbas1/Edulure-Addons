@extends('addons.communities.layouts.base')

@section('communities-content')
<h3>{{ __('communities::communities.admin_communities') }}</h3>
<table class="table">
    <thead>
        <tr>
            <th>{{ __('communities::communities.name') }}</th>
            <th>{{ __('communities::communities.owner') }}</th>
            <th>{{ __('communities::communities.members') }}</th>
            <th>{{ __('communities::communities.visibility') }}</th>
            <th>{{ __('communities::communities.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($communities as $community)
            <tr>
                <td>{{ $community->name }}</td>
                <td>{{ optional($community->owner)->name }}</td>
                <td>{{ $community->members_count ?? $community->members()->count() }}</td>
                <td>{{ $community->is_private ? __('communities::communities.private') : __('communities::communities.public') }}</td>
                <td>
                    <a href="{{ route('communities.show', $community) }}" class="btn btn-sm btn-outline-primary">{{ __('communities::communities.view') }}</a>
                    <form action="{{ route('communities.admin.deactivate', $community) }}" method="post" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-outline-danger">{{ __('communities::communities.deactivate') }}</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('addons.communities.components.pagination', ['paginator' => $communities])
@endsection

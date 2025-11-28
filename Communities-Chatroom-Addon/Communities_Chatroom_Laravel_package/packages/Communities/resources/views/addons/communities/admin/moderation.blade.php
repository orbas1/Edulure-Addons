@extends('addons.communities.layouts.base')

@section('communities-content')
<h3>{{ __('communities::communities.admin_moderation') }}</h3>
<div class="card">
    <div class="card-body">
        <form method="get" class="row g-2 mb-3">
            <div class="col-md-3">
                <select name="status" class="form-select form-select-sm">
                    <option value="">{{ __('communities::communities.all_statuses') }}</option>
                    <option value="open" @selected(request('status')==='open')>{{ __('communities::communities.status_open') }}</option>
                    <option value="resolved" @selected(request('status')==='resolved')>{{ __('communities::communities.status_resolved') }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select form-select-sm">
                    <option value="">{{ __('communities::communities.all_types') }}</option>
                    <option value="message">{{ __('communities::communities.message') }}</option>
                    <option value="feed">{{ __('communities::communities.feed') }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary btn-sm">{{ __('communities::communities.apply') }}</button>
            </div>
        </form>
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>{{ __('communities::communities.reporter') }}</th>
                    <th>{{ __('communities::communities.type') }}</th>
                    <th>{{ __('communities::communities.status') }}</th>
                    <th>{{ __('communities::communities.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                    <tr>
                        <td>{{ optional($report->reporter)->name }}</td>
                        <td>{{ $report->type }}</td>
                        <td>{{ $report->status }}</td>
                        <td>
                            <form method="post" action="{{ route('communities.admin.moderation.resolve', $report) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">{{ __('communities::communities.resolve') }}</button>
                            </form>
                            <form method="post" action="{{ route('communities.admin.moderation.ban', $report) }}" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger">{{ __('communities::communities.ban_user') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

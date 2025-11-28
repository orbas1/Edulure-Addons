<table class="table leaderboard-table">
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('communities::communities.user') }}</th>
            <th>{{ __('communities::communities.points') }}</th>
            <th>{{ __('communities::communities.level') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entries as $entry)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="d-flex align-items-center gap-2">
                    <img src="{{ $entry->user->avatar ?? '' }}" class="rounded-circle" width="32" height="32">
                    <span>{{ $entry->user->name }}</span>
                </td>
                <td>{{ $entry->points }}</td>
                <td>{{ $entry->level }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

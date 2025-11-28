<ul class="nav nav-tabs" role="tablist">
    @php($tabs = ['feed' => 'Feed', 'channels' => 'Channels', 'members' => 'Members', 'courses' => 'Courses', 'leaderboard' => 'Leaderboard'])
    @foreach($tabs as $key => $label)
        <li class="nav-item" role="presentation">
            <a class="nav-link @if($activeTab === $key) active @endif" href="{{ route('communities.show', [$community, 'tab' => $key]) }}">{{ __('communities::communities.tab_' . $key) }}</a>
        </li>
    @endforeach
    @can('update', $community)
        <li class="nav-item" role="presentation">
            <a class="nav-link @if($activeTab === 'settings') active @endif" href="{{ route('communities.show', [$community, 'tab' => 'settings']) }}">{{ __('communities::communities.tab_settings') }}</a>
        </li>
    @endcan
</ul>

<div class="activity-summary">
    <div class="activity-summary__stat">
        <div class="label">{{ __('communities::communities.posts') }}</div>
        <div class="value">{{ $stats['posts'] ?? 0 }}</div>
    </div>
    <div class="activity-summary__stat">
        <div class="label">{{ __('communities::communities.messages') }}</div>
        <div class="value">{{ $stats['messages'] ?? 0 }}</div>
    </div>
    <div class="activity-summary__stat">
        <div class="label">{{ __('communities::communities.members') }}</div>
        <div class="value">{{ $stats['members'] ?? 0 }}</div>
    </div>
</div>

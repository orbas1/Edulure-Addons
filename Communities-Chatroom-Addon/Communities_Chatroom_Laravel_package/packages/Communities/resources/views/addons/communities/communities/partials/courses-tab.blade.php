<div class="list-group">
    @foreach($courses as $course)
        <a href="{{ route('courses.show', $course->course_id ?? $course->id) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
            <div>
                <div class="fw-semibold">{{ $course->title ?? $course->name }}</div>
                <div class="text-muted small">{{ __('communities::communities.link_type_' . ($course->link_type ?? 'primary')) }}</div>
            </div>
            <span class="badge bg-light text-dark">{{ __('communities::communities.open_course') }}</span>
        </a>
    @endforeach
</div>

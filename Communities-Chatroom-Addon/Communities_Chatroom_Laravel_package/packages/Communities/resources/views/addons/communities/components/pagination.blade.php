@if($paginator->hasPages())
    <nav aria-label="Pagination">
        <ul class="pagination">
            @if($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">{{ __('communities::communities.prev') }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">{{ __('communities::communities.prev') }}</a></li>
            @endif

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            @if($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">{{ __('communities::communities.next') }}</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">{{ __('communities::communities.next') }}</span></li>
            @endif
        </ul>
    </nav>
@endif

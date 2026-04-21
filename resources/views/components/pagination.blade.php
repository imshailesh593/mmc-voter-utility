@if ($paginator->hasPages())
<div class="results-container">
    <nav class="pagination-wrapper" aria-label="Pagination">
        <ul class="pagination">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&lsaquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" wire:navigate>&lsaquo;</a></li>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="disabled"><span>{{ $element }}</span></li>
                @endif
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="active"><span>{{ $page }}</span></li>
                        @else
                            <li><a href="{{ $url }}" wire:navigate>{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" wire:navigate>&rsaquo;</a></li>
            @else
                <li class="disabled"><span>&rsaquo;</span></li>
            @endif
        </ul>
    </nav>
</div>
@endif

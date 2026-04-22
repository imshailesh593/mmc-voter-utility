@if ($paginator->hasPages())
<nav class="mmc-pag">
    <span class="mmc-pag-info">
        {{ number_format($paginator->firstItem() ?? 0) }}–{{ number_format($paginator->lastItem() ?? 0) }}
        of {{ number_format($paginator->total()) }}
    </span>

    <div class="mmc-pag-controls">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="mmc-pag-btn mmc-pag-btn--disabled">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="mmc-pag-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="mmc-pag-dots">···</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="mmc-pag-page mmc-pag-page--active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="mmc-pag-page">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="mmc-pag-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <span class="mmc-pag-btn mmc-pag-btn--disabled">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </div>
</nav>

<style>
.mmc-pag {
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem; flex-wrap: wrap; padding: 0.75rem 1rem;
    border-top: 1px solid var(--gray-100, #f1f5f9);
}
.mmc-pag-info {
    font-size: 0.72rem; font-weight: 600;
    color: var(--gray-400, #94a3b8);
    white-space: nowrap;
}
.mmc-pag-controls {
    display: flex; align-items: center; gap: 0.2rem; flex-wrap: wrap;
}
.mmc-pag-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px;
    border: 1.5px solid var(--gray-200, #e2e8f0);
    background: #fff; color: var(--gray-500, #64748b);
    text-decoration: none; transition: all 0.15s; flex-shrink: 0;
}
.mmc-pag-btn:hover { background: var(--red-50, #fef2f2); border-color: var(--red-300, #fca5a5); color: var(--red-600, #dc2626); }
.mmc-pag-btn--disabled { opacity: 0.35; cursor: not-allowed; pointer-events: none; }
.mmc-pag-page {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 30px; height: 30px; padding: 0 4px; border-radius: 7px;
    border: 1.5px solid transparent;
    font-size: 0.75rem; font-weight: 600; color: var(--gray-500, #64748b);
    text-decoration: none; transition: all 0.15s;
}
.mmc-pag-page:hover { background: var(--gray-100, #f1f5f9); color: var(--gray-800, #1e293b); }
.mmc-pag-page--active {
    background: var(--red-600, #dc2626); border-color: var(--red-600, #dc2626);
    color: #fff !important; cursor: default;
}
.mmc-pag-dots {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 24px; height: 30px;
    font-size: 0.75rem; color: var(--gray-300, #cbd5e1); letter-spacing: 0.05em;
}
</style>
@endif

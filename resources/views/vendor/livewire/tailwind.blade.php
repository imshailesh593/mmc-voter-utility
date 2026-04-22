@php
if (! isset($scrollTo)) { $scrollTo = 'body'; }
$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? "(\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()"
    : '';
@endphp

<div>
@if ($paginator->hasPages())
<nav class="mmc-pag">
    <span class="mmc-pag-info">
        {{ number_format($paginator->firstItem() ?? 0) }}–{{ number_format($paginator->lastItem() ?? 0) }}
        of {{ number_format($paginator->total()) }}
    </span>

    <div class="mmc-pag-controls">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="mmc-pag-btn mmc-pag-btn--disabled" aria-disabled="true">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </span>
        @else
            <button type="button"
                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                wire:loading.attr="disabled"
                class="mmc-pag-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            </button>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="mmc-pag-dots">···</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    <span wire:key="paginator-{{ $paginator->getPageName() }}-page{{ $page }}">
                        @if ($page == $paginator->currentPage())
                            <span class="mmc-pag-page mmc-pag-page--active" aria-current="page">{{ $page }}</span>
                        @else
                            <button type="button"
                                wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                class="mmc-pag-page">{{ $page }}</button>
                        @endif
                    </span>
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <button type="button"
                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                x-on:click="{{ $scrollIntoViewJsSnippet }}"
                wire:loading.attr="disabled"
                class="mmc-pag-btn">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </button>
        @else
            <span class="mmc-pag-btn mmc-pag-btn--disabled" aria-disabled="true">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
            </span>
        @endif
    </div>
</nav>

<style>
.mmc-pag {
    display: flex; align-items: center; justify-content: space-between;
    gap: 1rem; flex-wrap: wrap; padding: 0.75rem 1rem;
    border-top: 1px solid #f1f5f9;
}
.mmc-pag-info { font-size: 0.72rem; font-weight: 600; color: #94a3b8; white-space: nowrap; }
.mmc-pag-controls { display: flex; align-items: center; gap: 0.2rem; flex-wrap: wrap; }
.mmc-pag-btn {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px; border-radius: 7px;
    border: 1.5px solid #e2e8f0; background: #fff; color: #64748b;
    cursor: pointer; transition: all 0.15s; flex-shrink: 0;
    font-family: inherit;
}
.mmc-pag-btn:hover:not(:disabled) { background: #fef2f2; border-color: #fca5a5; color: #dc2626; }
.mmc-pag-btn--disabled { opacity: 0.35; cursor: not-allowed; }
.mmc-pag-page {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 30px; height: 30px; padding: 0 4px; border-radius: 7px;
    border: 1.5px solid transparent; background: none;
    font-size: 0.75rem; font-weight: 600; color: #64748b;
    cursor: pointer; transition: all 0.15s; font-family: inherit;
}
.mmc-pag-page:hover { background: #f1f5f9; color: #1e293b; }
.mmc-pag-page--active {
    background: #dc2626 !important; border-color: #dc2626 !important;
    color: #fff !important; cursor: default;
}
.mmc-pag-dots {
    display: inline-flex; align-items: center; justify-content: center;
    min-width: 24px; height: 30px; font-size: 0.75rem; color: #cbd5e1; letter-spacing: 0.05em;
}
</style>
@endif
</div>

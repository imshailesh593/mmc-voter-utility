@extends('layouts.app')

@section('title', 'Voter Search Portal — Dr. Sanjaykumar Deshmukh')

@section('extra-styles')
<style>
/* ── No page scroll — everything lives in 100vh ──────────────────────── */
html, body { height: 100%; overflow: hidden; }
.page-wrap  { height: 100vh; display: flex; flex-direction: column; overflow: hidden; }
.site-footer { display: none; }

/* ── Portal wrapper fills all remaining space ────────────────────────── */
.portal-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    background: #f1f5f9;
}

/* ── Hero: 55 % of viewport, image shown in full (no crop) ──────────── */
.hero-img-wrap {
    flex-shrink: 0;
    height: 55vh;
    background: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-bottom: 2px solid #fecaca;
}
.hero-img-wrap img {
    height: 100%;
    width: 100%;
    object-fit: contain;   /* shows full image — no cropping ever */
    object-position: center;
    display: block;
}

/* ── Search area: 45 % of viewport, scrolls internally on results ────── */
.search-outer {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 0.85rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    -webkit-overflow-scrolling: touch;
}

/* ── Compact search card ─────────────────────────────────────────────── */
.search-card {
    width: 100%;
    max-width: 680px;
    margin: 0 !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.11) !important;
}
.search-card-header        { padding: 0.65rem 1.5rem !important; }
.search-card-header h2     { font-size: 0.9rem !important; letter-spacing: 0.07em !important; }
.search-card-body          { padding: 0.85rem 1.25rem 0.9rem !important; }
.search-form               { gap: 0.5rem !important; }
.form-label                { font-size: 0.69rem !important; }
.form-input                { padding: 0.48rem 0.85rem !important; font-size: 0.85rem !important; border-radius: 8px !important; }
.btn-search                { padding: 0.6rem 1.25rem !important; font-size: 0.86rem !important; }
.btn-clear                 { padding: 0.6rem 0.85rem !important; font-size: 0.77rem !important; }
.divider-or                { font-size: 0.64rem !important; }

/* Results stay below card inside the scrollable area */
.results-container, .no-results {
    width: 100%;
    max-width: 680px;
    margin: 0 !important;
}
.no-results { padding: 1.25rem !important; }
.no-results-icon { width: 34px !important; height: 34px !important; }
</style>
@endsection

@section('content')
<div class="portal-wrap">

    {{-- ═══ COMPLETE HERO BANNER (full image, no cropping) ════════════════════ --}}
    <div class="hero-img-wrap">
        <img
            src="{{ asset('images/candidate-badge.png') }}"
            alt="Maharashtra Medical Council Elections 2026 — Dr. Sanjaykumar S. Deshmukh SR.No.13"
        >
    </div>

    {{-- ═══ SEARCH FORM ════════════════════════════════════════════════════════ --}}
    <div class="search-outer">
        <div class="search-card">
            <div class="search-card-header">
                <h2>Voter Search Portal</h2>
            </div>
            <div class="search-card-body">
                @livewire('voter-search')
            </div>
        </div>
    </div>

</div>
@endsection

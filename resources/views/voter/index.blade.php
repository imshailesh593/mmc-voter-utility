@extends('layouts.app')

@section('title', 'Voter Search Portal — Dr. Sanjaykumar Deshmukh')

@section('extra-styles')
<style>
/* ── Page layout ─────────────────────────────────────────────────────── */
html, body { height: 100%; }
.page-wrap  { min-height: 100vh; display: flex; flex-direction: column; }
.site-footer { display: none; }

/* ── Portal wrapper ──────────────────────────────────────────────────── */
.portal-wrap {
    flex: 1;
    display: flex;
    flex-direction: column;
    background: #f1f5f9;
}

/* ── Hero ─────────────────────────────────────────────────────────────── */
.hero-img-wrap {
    background: #ffffff;
    border-bottom: 2px solid #fecaca;
    max-height: 52vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}
.hero-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center top;
    display: block;
}

/* ── Search area ─────────────────────────────────────────────────────── */
.search-outer {
    padding: 1.25rem 1rem 2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
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

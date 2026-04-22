@extends('layouts.app')
@section('title', 'Voter Search Portal — Dr. Sanjaykumar Deshmukh')

@section('extra-styles')
<style>
body { background: #f0f4f8; }

/* ── Search card — floated glass card ──────────────────────────────── */
.main-content { padding-top: 0; padding-bottom: 3rem; }
.search-card {
    max-width: 680px;
    margin: 1.5rem auto 0 !important;
    position: relative;
    z-index: 20;
    background: rgba(255,255,255,0.97) !important;
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    box-shadow: 0 24px 64px rgba(0,0,0,0.14), 0 0 0 1px rgba(255,255,255,0.7) !important;
    border-radius: 20px !important;
}
.search-card-header {
    background: linear-gradient(135deg, #b91c1c 0%, #ef4444 100%) !important;
    border-radius: 20px 20px 0 0 !important;
    padding: 1rem 1.75rem !important;
}
.search-card-header h2 {
    font-size: 0.92rem !important;
    letter-spacing: 0.1em !important;
}
.search-card-body { padding: 1.5rem 1.75rem !important; }
.search-form { gap: 1rem !important; }
.form-input {
    border-radius: 10px !important;
    padding: 0.75rem 1rem !important;
    font-size: 0.9rem !important;
    border: 1.5px solid #e2e8f0 !important;
    transition: border-color 0.2s, box-shadow 0.2s !important;
}
.form-input:focus {
    border-color: #ef4444 !important;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.1) !important;
}
.btn-search {
    padding: 0.8rem 1.5rem !important;
    border-radius: 10px !important;
    font-size: 0.9rem !important;
    letter-spacing: 0.03em !important;
    box-shadow: 0 4px 14px rgba(185,28,28,0.35) !important;
}
.btn-search:hover { box-shadow: 0 6px 20px rgba(185,28,28,0.45) !important; }

/* ── Results ───────────────────────────────────────────────────────── */
.results-container {
    max-width: 680px;
    margin: 1.5rem auto 0 !important;
}
.results-count {
    font-size: 0.88rem !important;
    font-weight: 700 !important;
    color: #475569 !important;
    padding: 0 0.25rem;
}

.voter-card {
    border-left: 3px solid #ef4444 !important;
    border-radius: 12px !important;
    padding: 1rem 1.25rem !important;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05) !important;
    background: #fff !important;
    animation: cardIn 0.3s ease both;
}
.voter-card:nth-child(1) { animation-delay: 0.04s; }
.voter-card:nth-child(2) { animation-delay: 0.08s; }
.voter-card:nth-child(3) { animation-delay: 0.12s; }
.voter-card:nth-child(4) { animation-delay: 0.16s; }
.voter-card:nth-child(5) { animation-delay: 0.20s; }
.voter-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.1) !important;
    transform: translateY(-2px) !important;
    border-left-color: #b91c1c !important;
}
@keyframes cardIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

.voter-name { font-size: 1rem !important; font-weight: 800 !important; letter-spacing: 0.01em !important; }

.voter-avatar {
    width: 46px !important; height: 46px !important;
    font-size: 1.15rem !important; font-weight: 900 !important;
    box-shadow: 0 4px 12px rgba(220,38,38,0.25) !important;
}

.btn-slip {
    border-radius: 8px !important;
    padding: 0.5rem 0.9rem !important;
    font-size: 0.75rem !important;
    box-shadow: 0 3px 10px rgba(185,28,28,0.3) !important;
    letter-spacing: 0.02em !important;
}
.btn-slip:hover { box-shadow: 0 5px 16px rgba(185,28,28,0.4) !important; }

.no-results {
    max-width: 680px;
    margin: 1.5rem auto 0 !important;
    border-radius: 16px !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07) !important;
}

@media (max-width: 700px) {
    .search-card { margin: 1rem 1rem 0 !important; }
}
</style>
@endsection

@section('content')

{{-- ═══ HERO ═══════════════════════════════════════════════════════════════ --}}
<div style="background:#fff; box-shadow:0 4px 24px rgba(0,0,0,0.08);">
    <img
        src="{{ asset('images/candidate-badge.png') }}"
        alt="Maharashtra Medical Council Elections 2026 — Dr. Sanjaykumar S. Deshmukh SR.No.13"
        style="width:100%; max-height:52vh; object-fit:contain; object-position:center; display:block;"
    >
</div>

{{-- ═══ SEARCH ══════════════════════════════════════════════════════════════ --}}
<div class="main-content">
    <div class="search-card">
        <div class="search-card-header">
            <h2>Voter Search Portal</h2>
        </div>
        <div class="search-card-body">
            @livewire('voter-search')
        </div>
    </div>
</div>

@endsection

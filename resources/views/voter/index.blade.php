@extends('layouts.app')
@section('title', 'Voter Search Portal — Dr. Sanjaykumar Deshmukh')

@section('extra-styles')
<style>
/* ── Premium background ────────────────────────────────────────────── */
body {
    background-color: #faf5f5;
    background-image:
        radial-gradient(ellipse at 15% 40%, rgba(185,28,28,0.08) 0%, transparent 55%),
        radial-gradient(ellipse at 85% 15%, rgba(220,38,38,0.06) 0%, transparent 50%),
        radial-gradient(ellipse at 55% 95%, rgba(239,68,68,0.07) 0%, transparent 50%),
        url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23dc2626' fill-opacity='0.025'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    background-attachment: fixed;
}

/* ── Hero ──────────────────────────────────────────────────────────── */
.hero-wrap {
    position: relative;
    box-shadow: 0 8px 32px rgba(185,28,28,0.15);
}
.hero-wrap::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 60px;
    background: linear-gradient(to bottom, transparent, rgba(250,245,245,0.6));
    pointer-events: none;
}

/* ── Search card ───────────────────────────────────────────────────── */
.main-content { padding-top: 0; padding-bottom: 4rem; }
.search-card {
    max-width: 680px;
    margin: 2rem auto 0 !important;
    position: relative;
    z-index: 20;
    background: rgba(255,255,255,0.95) !important;
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    box-shadow:
        0 2px 4px rgba(185,28,28,0.04),
        0 8px 24px rgba(0,0,0,0.08),
        0 32px 64px rgba(0,0,0,0.1),
        inset 0 1px 0 rgba(255,255,255,0.9) !important;
    border-radius: 24px !important;
    border: 1px solid rgba(255,255,255,0.8) !important;
    overflow: hidden !important;
}
.search-card-header {
    background: linear-gradient(135deg, #991b1b 0%, #dc2626 50%, #ef4444 100%) !important;
    border-radius: 0 !important;
    padding: 1.1rem 1.75rem !important;
    position: relative;
    overflow: hidden;
}
.search-card-header::before {
    content: '';
    position: absolute;
    top: -50%; right: -20%;
    width: 200px; height: 200px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
}
.search-card-header h2 {
    font-size: 0.88rem !important;
    letter-spacing: 0.12em !important;
    text-shadow: 0 1px 3px rgba(0,0,0,0.2) !important;
}
.search-card-body { padding: 1.75rem !important; }
.search-form { gap: 1.1rem !important; }
.form-label { font-size: 0.72rem !important; letter-spacing: 0.08em !important; color: #64748b !important; }
.form-input {
    border-radius: 12px !important;
    padding: 0.8rem 1.1rem !important;
    font-size: 0.92rem !important;
    border: 1.5px solid #e8eef4 !important;
    background: #fafbfc !important;
    transition: all 0.2s !important;
}
.form-input:focus {
    border-color: #dc2626 !important;
    background: #fff !important;
    box-shadow: 0 0 0 4px rgba(220,38,38,0.08) !important;
}
.btn-search {
    padding: 0.85rem 1.5rem !important;
    border-radius: 12px !important;
    font-size: 0.9rem !important;
    letter-spacing: 0.04em !important;
    background: linear-gradient(135deg, #991b1b, #dc2626, #ef4444) !important;
    box-shadow: 0 4px 6px rgba(153,27,27,0.2), 0 8px 20px rgba(220,38,38,0.3) !important;
    transition: all 0.2s !important;
}
.btn-search:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 6px 10px rgba(153,27,27,0.25), 0 12px 28px rgba(220,38,38,0.35) !important;
}
.btn-clear {
    border-radius: 12px !important;
    border: 1.5px solid #e2e8f0 !important;
}

/* ── Results ───────────────────────────────────────────────────────── */
.results-container { max-width: 680px; margin: 1.75rem auto 0 !important; }
.results-count { font-size: 0.85rem !important; font-weight: 700 !important; color: #64748b !important; }
.count-badge {
    background: linear-gradient(135deg, #b91c1c, #ef4444) !important;
    box-shadow: 0 2px 8px rgba(185,28,28,0.4) !important;
    font-size: 0.72rem !important;
}

.voter-card {
    border-left: 3px solid #dc2626 !important;
    border-radius: 14px !important;
    padding: 1rem 1.25rem !important;
    background: rgba(255,255,255,0.9) !important;
    backdrop-filter: blur(8px) !important;
    box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.06) !important;
    transition: all 0.22s cubic-bezier(0.4,0,0.2,1) !important;
    animation: cardIn 0.35s cubic-bezier(0.4,0,0.2,1) both;
}
.voter-card:nth-child(1) { animation-delay: 0.05s; }
.voter-card:nth-child(2) { animation-delay: 0.1s; }
.voter-card:nth-child(3) { animation-delay: 0.15s; }
.voter-card:nth-child(4) { animation-delay: 0.2s; }
.voter-card:nth-child(5) { animation-delay: 0.25s; }
.voter-card:hover {
    transform: translateY(-3px) translateX(2px) !important;
    box-shadow: 0 4px 8px rgba(0,0,0,0.06), 0 12px 32px rgba(185,28,28,0.12) !important;
    border-left-color: #991b1b !important;
    background: #fff !important;
}
@keyframes cardIn {
    from { opacity: 0; transform: translateY(16px) scale(0.98); }
    to   { opacity: 1; transform: translateY(0) scale(1); }
}

.voter-name { font-size: 0.98rem !important; font-weight: 800 !important; letter-spacing: 0.01em !important; color: #1e293b !important; }
.voter-branch, .voter-reg {
    background: #f8fafc !important;
    border: 1px solid #e8eef4 !important;
    font-size: 0.7rem !important;
}

.voter-avatar {
    width: 46px !important; height: 46px !important;
    font-size: 1.1rem !important; font-weight: 900 !important;
    background: linear-gradient(145deg, #b91c1c, #f87171) !important;
    box-shadow: 0 4px 14px rgba(185,28,28,0.35) !important;
}

.btn-slip {
    border-radius: 10px !important;
    padding: 0.5rem 0.95rem !important;
    font-size: 0.73rem !important;
    background: linear-gradient(135deg, #991b1b, #dc2626) !important;
    box-shadow: 0 3px 10px rgba(153,27,27,0.35) !important;
    letter-spacing: 0.03em !important;
    transition: all 0.2s !important;
}
.btn-slip:hover {
    transform: translateY(-1px) !important;
    box-shadow: 0 5px 16px rgba(153,27,27,0.45) !important;
}

.no-results {
    max-width: 680px; margin: 1.75rem auto 0 !important;
    border-radius: 20px !important;
    background: rgba(255,255,255,0.9) !important;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07) !important;
}

/* ── Footer ────────────────────────────────────────────────────────── */
.site-footer {
    background: linear-gradient(135deg, #0f172a, #1e293b) !important;
    border-top: 1px solid rgba(220,38,38,0.3) !important;
    padding: 1.25rem !important;
    line-height: 2 !important;
}
.site-footer a { color: #fca5a5 !important; }
.site-footer a:hover { color: #fff !important; }

@media (max-width: 700px) {
    .search-card { margin: 1.25rem 0.75rem 0 !important; border-radius: 18px !important; }
}
</style>
@endsection

@section('content')

{{-- ═══ HERO ═══════════════════════════════════════════════════════════════ --}}
<div class="hero-wrap" style="background:#fff;">
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

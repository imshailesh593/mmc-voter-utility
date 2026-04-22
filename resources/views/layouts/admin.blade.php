<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — MMC Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --red-700: #b91c1c; --red-600: #dc2626; --red-500: #ef4444;
            --red-200: #fecaca; --red-100: #fee2e2; --red-50: #fef2f2;
            --white: #ffffff;
            --gray-50: #f8fafc; --gray-100: #f1f5f9; --gray-200: #e2e8f0;
            --gray-300: #cbd5e1; --gray-400: #94a3b8; --gray-500: #64748b;
            --gray-600: #475569; --gray-700: #334155; --gray-800: #1e293b; --gray-900: #0f172a;
            --sidebar-w: 240px;
        }
        html, body { height: 100%; font-family: 'Inter', sans-serif; background: var(--gray-100); color: var(--gray-800); font-size: 14px; }

        /* ── Shell ─────────────────────────────────────────── */
        .shell { display: flex; min-height: 100vh; }

        /* ── Sidebar ───────────────────────────────────────── */
        .sidebar {
            width: var(--sidebar-w); flex-shrink: 0;
            background: var(--gray-900);
            display: flex; flex-direction: column;
            position: fixed; top: 0; left: 0; bottom: 0;
            z-index: 100; overflow-y: auto;
        }
        .sidebar-brand {
            padding: 1.25rem 1.25rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-brand-title {
            font-size: 0.72rem; font-weight: 800; letter-spacing: 0.1em;
            text-transform: uppercase; color: var(--red-400);
        }
        .sidebar-brand-sub {
            font-size: 0.62rem; color: rgba(255,255,255,0.35); margin-top: 2px;
        }
        .sidebar-nav { padding: 0.75rem 0.6rem; flex: 1; }
        .nav-section-label {
            font-size: 0.58rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.12em; color: rgba(255,255,255,0.25);
            padding: 0.5rem 0.65rem 0.3rem;
        }
        .nav-link {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.52rem 0.7rem; border-radius: 7px;
            color: rgba(255,255,255,0.6); font-size: 0.82rem; font-weight: 500;
            text-decoration: none; transition: background 0.15s, color 0.15s;
            margin-bottom: 2px;
        }
        .nav-link:hover { background: rgba(255,255,255,0.07); color: var(--white); }
        .nav-link.active { background: var(--red-700); color: var(--white); font-weight: 600; }
        .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; }
        .nav-divider { height: 1px; background: rgba(255,255,255,0.07); margin: 0.6rem 0.65rem; }
        .sidebar-footer {
            padding: 0.85rem 1rem;
            border-top: 1px solid rgba(255,255,255,0.07);
        }
        .sidebar-footer a {
            display: flex; align-items: center; gap: 0.5rem;
            font-size: 0.75rem; color: rgba(255,255,255,0.4); text-decoration: none;
        }
        .sidebar-footer a:hover { color: rgba(255,255,255,0.7); }
        .sidebar-footer svg { width: 14px; height: 14px; }

        /* ── Main ──────────────────────────────────────────── */
        .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* ── Topbar ────────────────────────────────────────── */
        .topbar {
            background: var(--white); border-bottom: 1px solid var(--gray-200);
            padding: 0 1.5rem; height: 54px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 50;
        }
        .topbar-title { font-size: 0.92rem; font-weight: 700; color: var(--gray-800); }
        .topbar-right { display: flex; align-items: center; gap: 1rem; }
        .topbar-badge {
            background: var(--red-50); color: var(--red-700);
            border: 1px solid var(--red-200);
            font-size: 0.7rem; font-weight: 700;
            padding: 0.18rem 0.55rem; border-radius: 100px;
        }

        /* ── Page content ──────────────────────────────────── */
        .page { padding: 1.5rem; flex: 1; }

        /* ── Stat cards ────────────────────────────────────── */
        .stat-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .stat-card {
            background: var(--white); border-radius: 12px;
            border: 1px solid var(--gray-200);
            padding: 1.1rem 1.25rem;
            display: flex; flex-direction: column; gap: 0.35rem;
        }
        .stat-card-label { font-size: 0.68rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--gray-400); }
        .stat-card-value { font-size: 1.85rem; font-weight: 900; color: var(--gray-900); line-height: 1; }
        .stat-card-sub { font-size: 0.7rem; color: var(--gray-500); }
        .stat-card.accent .stat-card-value { color: var(--red-600); }

        /* ── Section card ──────────────────────────────────── */
        .card {
            background: var(--white); border-radius: 12px;
            border: 1px solid var(--gray-200); overflow: hidden;
        }
        .card-header {
            padding: 0.9rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
            display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;
        }
        .card-title { font-size: 0.88rem; font-weight: 700; color: var(--gray-800); }
        .card-body { padding: 1.25rem; }

        /* ── Toolbar ───────────────────────────────────────── */
        .toolbar { display: flex; gap: 0.6rem; flex-wrap: wrap; align-items: center; }
        .toolbar-input {
            border: 1.5px solid var(--gray-200); border-radius: 8px;
            padding: 0.45rem 0.8rem; font-size: 0.82rem; font-family: inherit;
            background: var(--gray-50); color: var(--gray-800); outline: none;
            transition: border-color 0.15s;
        }
        .toolbar-input:focus { border-color: var(--red-400); background: var(--white); }
        .toolbar-input.wide { min-width: 220px; }
        .toolbar-select {
            border: 1.5px solid var(--gray-200); border-radius: 8px;
            padding: 0.45rem 0.7rem; font-size: 0.82rem; font-family: inherit;
            background: var(--gray-50); color: var(--gray-800); outline: none;
            cursor: pointer;
        }
        .toolbar-select:focus { border-color: var(--red-400); }
        .toolbar-spacer { flex: 1; }
        .btn {
            display: inline-flex; align-items: center; gap: 0.35rem;
            padding: 0.45rem 0.9rem; border-radius: 8px;
            font-size: 0.8rem; font-weight: 600; font-family: inherit;
            cursor: pointer; border: none; transition: filter 0.15s;
            text-decoration: none; white-space: nowrap;
        }
        .btn svg { width: 14px; height: 14px; }
        .btn-primary { background: var(--red-600); color: var(--white); }
        .btn-primary:hover { filter: brightness(1.08); }
        .btn-ghost { background: var(--gray-100); color: var(--gray-600); border: 1.5px solid var(--gray-200); }
        .btn-ghost:hover { background: var(--gray-200); }
        .btn-danger { background: #fef2f2; color: #991b1b; border: 1.5px solid #fecaca; }
        .btn-danger:hover { background: #fee2e2; }
        .btn-sm { padding: 0.28rem 0.6rem; font-size: 0.72rem; }

        /* ── Table ─────────────────────────────────────────── */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.82rem; }
        thead tr { background: var(--gray-50); }
        th {
            padding: 0.65rem 1rem; text-align: left;
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.07em; color: var(--gray-400);
            border-bottom: 1px solid var(--gray-200);
            white-space: nowrap;
        }
        td {
            padding: 0.7rem 1rem; border-bottom: 1px solid var(--gray-100);
            color: var(--gray-700);
        }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: var(--gray-50); }
        .td-name { font-weight: 600; color: var(--gray-800); }
        .td-badge {
            display: inline-block;
            background: var(--gray-100); color: var(--gray-600);
            font-size: 0.68rem; font-weight: 600;
            padding: 0.1rem 0.45rem; border-radius: 100px;
        }
        .td-actions { display: flex; gap: 0.35rem; }

        /* ── Branch list ───────────────────────────────────── */
        .branch-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 0.65rem; }
        .branch-card {
            background: var(--gray-50); border: 1.5px solid var(--gray-200);
            border-radius: 10px; padding: 0.75rem 1rem;
            display: flex; align-items: center; justify-content: space-between;
            gap: 0.5rem;
        }
        .branch-card-name { font-size: 0.82rem; font-weight: 600; color: var(--gray-800); }
        .branch-card-count { font-size: 0.72rem; color: var(--gray-400); }
        .branch-card-num { font-size: 1.1rem; font-weight: 900; color: var(--red-600); }

        /* ── Alerts ────────────────────────────────────────── */
        .alert { display: flex; align-items: flex-start; gap: 0.5rem; padding: 0.7rem 1rem; border-radius: 8px; font-size: 0.82rem; font-weight: 500; }
        .alert svg { width: 15px; height: 15px; flex-shrink: 0; margin-top: 1px; }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-error { background: var(--red-50); color: #991b1b; border: 1px solid var(--red-200); }
        .alert-info { background: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe; }

        /* ── Empty state ───────────────────────────────────── */
        .empty { text-align: center; padding: 3rem 1rem; color: var(--gray-400); }
        .empty svg { width: 40px; height: 40px; margin: 0 auto 0.75rem; }
        .empty h3 { font-size: 0.95rem; font-weight: 600; color: var(--gray-500); margin-bottom: 0.25rem; }
        .empty p { font-size: 0.8rem; }

        /* ── Pagination ────────────────────────────────────── */
        .pag-wrap { padding: 0.85rem 1rem; border-top: 1px solid var(--gray-100); display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; }
        .pag-info { font-size: 0.75rem; color: var(--gray-400); }
        .pagination { display: flex; gap: 0.25rem; list-style: none; flex-wrap: wrap; }
        .pagination span, .pagination a {
            padding: 0.3rem 0.6rem; border-radius: 6px; font-size: 0.75rem; font-weight: 600;
            border: 1px solid var(--gray-200); color: var(--gray-500); text-decoration: none; display: block;
        }
        .pagination a:hover { background: var(--red-50); border-color: var(--red-200); color: var(--red-700); }
        .pagination .active span { background: var(--red-600); border-color: var(--red-600); color: var(--white); }
        .pagination .disabled span { color: var(--gray-300); background: var(--gray-50); }

        /* ── Upload ────────────────────────────────────────── */
        .upload-zone {
            border: 2px dashed var(--gray-200); border-radius: 10px;
            padding: 2.5rem 1.5rem; text-align: center; cursor: pointer;
            transition: border-color 0.2s, background 0.2s; background: var(--gray-50);
            display: flex; flex-direction: column; align-items: center; gap: 0.5rem;
        }
        .upload-zone:hover, .upload-zone.dragging { border-color: var(--red-400); background: var(--red-50); }
        .upload-zone svg { width: 36px; height: 36px; color: var(--red-400); }
        .upload-zone-text { font-size: 0.86rem; font-weight: 600; color: var(--gray-600); }
        .upload-zone-sub { font-size: 0.74rem; color: var(--gray-400); }
        .upload-zone-file { font-size: 0.84rem; font-weight: 700; color: var(--red-700); }

        /* ── Loading ───────────────────────────────────────── */
        .loading-bar { height: 3px; background: var(--gray-100); overflow: hidden; border-radius: 2px; }
        .loading-bar-fill { height: 100%; background: linear-gradient(90deg, var(--red-500), #fca5a5); animation: lbar 1.4s ease-in-out infinite; }
        @keyframes lbar { 0%{width:0%;margin-left:0%} 50%{width:60%;margin-left:20%} 100%{width:0%;margin-left:100%} }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* ── Confirm overlay ───────────────────────────────── */
        .confirm-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.45);
            display: flex; align-items: center; justify-content: center;
            z-index: 200; padding: 1rem;
        }
        .confirm-box {
            background: var(--white); border-radius: 14px;
            padding: 1.75rem; max-width: 400px; width: 100%;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
        }
        .confirm-box h3 { font-size: 1rem; font-weight: 800; margin-bottom: 0.5rem; }
        .confirm-box p { font-size: 0.83rem; color: var(--gray-500); margin-bottom: 1.25rem; }
        .confirm-actions { display: flex; gap: 0.65rem; justify-content: flex-end; }

        /* ── Responsive ────────────────────────────────────── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.25s; }
            .sidebar.open { transform: translateX(0); }
            .main { margin-left: 0; }
            .stat-grid { grid-template-columns: repeat(2, 1fr); }
        }
    </style>
    @yield('extra-styles')
</head>
<body>
<div class="shell">

    {{-- ═══ SIDEBAR ════════════════════════════════════════════════════════════ --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-title">MMC Admin Panel</div>
            <div class="sidebar-brand-sub">Elections 2026</div>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-label">Overview</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <div class="nav-divider"></div>
            <div class="nav-section-label">Voters</div>

            <a href="{{ route('admin.voters') }}" class="nav-link {{ request()->routeIs('admin.voters') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                All Voters
            </a>

            <a href="{{ route('admin.branches') }}" class="nav-link {{ request()->routeIs('admin.branches') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Branches
            </a>

            <a href="{{ route('admin.marking') }}" class="nav-link {{ request()->routeIs('admin.marking') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Voter Marking
            </a>

            <div class="nav-divider"></div>
            <div class="nav-section-label">Data</div>

            <a href="{{ route('admin.import') }}" class="nav-link {{ request()->routeIs('admin.import') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/></svg>
                Import
            </a>

            <div class="nav-divider"></div>
            <div class="nav-section-label">Settings</div>

            <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Users
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="{{ route('home') }}" target="_blank" style="margin-bottom:0.5rem">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View Public Portal
            </a>
            <form method="POST" action="{{ route('admin.logout') }}" style="margin-top:0.5rem">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;display:flex;align-items:center;gap:0.5rem;font-size:0.75rem;color:rgba(255,255,255,0.4);font-family:inherit;padding:0;width:100%">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- ═══ MAIN ════════════════════════════════════════════════════════════════ --}}
    <div class="main">
        <div class="topbar">
            <span class="topbar-title">@yield('title', 'Dashboard')</span>
            <div class="topbar-right">
                <span class="topbar-badge">MMC Elections 2026</span>
            </div>
        </div>

        <div class="page">
            @yield('content')
        </div>
    </div>

</div>
@livewireScripts
@yield('extra-scripts')
</body>
</html>

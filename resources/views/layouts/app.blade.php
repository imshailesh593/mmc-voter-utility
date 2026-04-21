<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Voter Portal') — MMC Elections 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;600;700;800;900&family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @livewireStyles
    <style>
        /* ─── Reset & Variables ──────────────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --red-700:    #b91c1c;
            --red-600:    #dc2626;
            --red-500:    #ef4444;
            --red-400:    #f87171;
            --red-200:    #fecaca;
            --red-100:    #fee2e2;
            --red-50:     #fef2f2;
            --salmon:     #f9a8a8;
            --salmon-bg:  #fde8e8;
            --pink-strip: linear-gradient(135deg, #f87171 0%, #fca5a5 100%);
            --white:      #ffffff;
            --gray-50:    #f8fafc;
            --gray-100:   #f1f5f9;
            --gray-200:   #e2e8f0;
            --gray-300:   #cbd5e1;
            --gray-400:   #94a3b8;
            --gray-500:   #64748b;
            --gray-600:   #475569;
            --gray-800:   #1e293b;
            --gray-900:   #0f172a;
            --shadow-sm:  0 1px 3px rgba(0,0,0,0.07);
            --shadow-md:  0 4px 6px -1px rgba(0,0,0,0.08), 0 2px 4px -1px rgba(0,0,0,0.04);
            --shadow-lg:  0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -2px rgba(0,0,0,0.04);
            --shadow-xl:  0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
            --radius-sm:  6px;
            --radius-md:  10px;
            --radius-lg:  14px;
            --radius-xl:  20px;
        }
        html { font-size: 16px; scroll-behavior: smooth; }
        body {
            font-family: 'Inter', 'Noto Sans Devanagari', sans-serif;
            background: var(--gray-50);
            color: var(--gray-800);
            line-height: 1.6;
            min-height: 100vh;
        }
        .page-wrap { min-height: 100vh; display: flex; flex-direction: column; }
        .main-content { flex: 1; padding: 0 1rem 3rem; }

        /* ─── Hero Banner ────────────────────────────────────────────────── */
        .hero-banner {
            background: #fff;
            border-bottom: 3px solid var(--red-200);
            position: relative;
        }

        /* Top strip: logos + title */
        .hero-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1.5rem 0.5rem;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .hero-logo-left, .hero-logo-right {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            font-size: 0.55rem;
            font-weight: 700;
            color: var(--gray-600);
            letter-spacing: 0.03em;
            line-height: 1.3;
            max-width: 90px;
        }
        .hero-logo-left img, .hero-logo-right img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            margin-bottom: 3px;
        }
        .hero-title-block { text-align: center; flex: 1; }
        .hero-title-main {
            font-size: clamp(1rem, 3.5vw, 1.5rem);
            font-weight: 900;
            color: var(--gray-900);
            letter-spacing: 0.02em;
            line-height: 1.15;
            text-transform: uppercase;
        }

        /* Candidate row */
        .hero-candidate {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 0.75rem 1.5rem 0;
            flex-wrap: wrap;
        }
        .candidate-photo-wrap {
            position: relative;
            flex-shrink: 0;
        }
        .candidate-photo-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid var(--red-500);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gray-100);
            box-shadow: 0 0 0 3px var(--red-100);
        }
        .candidate-photo-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .serial-badge {
            position: absolute;
            top: -4px;
            left: -4px;
            background: var(--red-600);
            border-radius: 50%;
            width: 52px;
            height: 52px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(220,38,38,0.45);
            border: 2px solid var(--white);
        }
        .serial-badge-label {
            font-size: 0.42rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: 0.08em;
            line-height: 1;
        }
        .serial-badge-num {
            font-size: 1.1rem;
            font-weight: 900;
            color: var(--white);
            line-height: 1;
        }
        .candidate-info { flex: 1; min-width: 0; }
        .candidate-panel-label {
            font-size: 0.8rem;
            color: var(--gray-500);
            margin-bottom: 0.2rem;
            font-weight: 500;
        }
        .candidate-name {
            font-size: clamp(1.15rem, 4vw, 1.8rem);
            font-weight: 900;
            color: var(--red-600);
            line-height: 1.1;
            letter-spacing: 0.01em;
            text-transform: uppercase;
            margin-bottom: 0.4rem;
        }
        .candidate-designation {
            display: inline-block;
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            color: var(--gray-700);
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0.2rem 0.75rem;
            border-radius: var(--radius-sm);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .candidate-divider {
            height: 3px;
            background: var(--red-600);
            width: 80px;
            border-radius: 2px;
            margin: 0.55rem 0;
        }

        /* Pink numbers strip */
        .numbers-strip {
            background: var(--pink-strip);
            padding: 0.85rem 1.5rem;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 0.85rem;
        }
        .number-box {
            background: var(--white);
            color: var(--red-600);
            font-size: 1rem;
            font-weight: 900;
            min-width: 40px;
            height: 40px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: var(--shadow-sm);
        }
        .numbers-tagline {
            flex: 1;
            text-align: center;
            font-size: 0.82rem;
            font-weight: 800;
            color: var(--white);
            text-transform: uppercase;
            letter-spacing: 0.04em;
            text-shadow: 0 1px 3px rgba(0,0,0,0.2);
        }

        /* Bottom date bar */
        .election-bar {
            background: var(--gray-900);
            padding: 0.55rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2.5rem;
            flex-wrap: wrap;
        }
        .election-bar-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--white);
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }
        .election-bar-item svg { width: 14px; height: 14px; flex-shrink: 0; color: var(--red-400); }
        .election-bar-dot {
            width: 8px; height: 8px;
            background: var(--red-500);
            border-radius: 50%;
        }

        /* ─── Search Card ────────────────────────────────────────────────── */
        .search-card {
            max-width: 680px;
            margin: 2rem auto 0;
            background: var(--white);
            border-radius: var(--radius-xl);
            box-shadow: var(--shadow-xl);
            overflow: hidden;
            position: relative;
            z-index: 10;
        }
        .search-card-header {
            background: linear-gradient(135deg, var(--red-700), var(--red-500));
            padding: 1.1rem 1.75rem;
            text-align: center;
        }
        .search-card-header h2 {
            font-size: 1.05rem;
            font-weight: 800;
            color: var(--white);
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }
        .search-card-body { padding: 1.75rem; }

        /* ─── Form ───────────────────────────────────────────────────────── */
        .search-form { display: flex; flex-direction: column; gap: 1.1rem; }
        .form-group { display: flex; flex-direction: column; gap: 0.35rem; }
        .form-label {
            font-size: 0.78rem;
            font-weight: 700;
            color: var(--gray-600);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }
        .required-star { color: var(--red-500); }
        .form-input {
            width: 100%;
            padding: 0.72rem 1rem;
            border: 2px solid var(--gray-200);
            border-radius: var(--radius-md);
            font-size: 0.92rem;
            color: var(--gray-800);
            background: var(--gray-50);
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            font-family: inherit;
        }
        .form-input:focus {
            border-color: var(--red-500);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
        }
        .form-input.input-error { border-color: var(--red-500); }
        .field-error { font-size: 0.76rem; color: var(--red-600); font-weight: 500; }
        .divider-or {
            display: flex; align-items: center; gap: 0.75rem;
            color: var(--gray-400); font-size: 0.72rem; font-weight: 700; letter-spacing: 0.1em;
        }
        .divider-or::before, .divider-or::after { content: ''; flex: 1; height: 1px; background: var(--gray-200); }
        .form-actions { display: flex; gap: 0.75rem; }
        .btn-search {
            flex: 1; display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.85rem 1.5rem;
            background: linear-gradient(135deg, var(--red-700), var(--red-500));
            color: var(--white); border: none; border-radius: var(--radius-md);
            font-size: 0.95rem; font-weight: 700; letter-spacing: 0.04em;
            cursor: pointer; transition: filter 0.15s, box-shadow 0.15s, transform 0.12s;
            font-family: inherit;
        }
        .btn-search:hover { filter: brightness(1.07); box-shadow: var(--shadow-md); transform: translateY(-1px); }
        .btn-search:active { transform: translateY(0); }
        .btn-search .btn-icon { width: 17px; height: 17px; }
        .btn-clear {
            padding: 0.85rem 1rem; background: var(--gray-100); color: var(--gray-600);
            border: 2px solid var(--gray-200); border-radius: var(--radius-md);
            font-size: 0.85rem; font-weight: 600; cursor: pointer;
            transition: background 0.15s; font-family: inherit; white-space: nowrap;
        }
        .btn-clear:hover { background: var(--gray-200); }

        /* ─── Alerts ─────────────────────────────────────────────────────── */
        .alert-error, .alert-success {
            display: flex; align-items: flex-start; gap: 0.6rem;
            padding: 0.75rem 1rem; border-radius: var(--radius-md);
            font-size: 0.85rem; font-weight: 500;
        }
        .alert-error { background: var(--red-50); color: #991b1b; border: 1px solid var(--red-200); }
        .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
        .alert-icon { width: 17px; height: 17px; flex-shrink: 0; margin-top: 1px; }

        /* Loading bar */
        .loading-bar { height: 3px; background: var(--gray-100); overflow: hidden; margin: 0.5rem 0; }
        .loading-bar-inner {
            height: 100%;
            background: linear-gradient(90deg, var(--red-500), var(--salmon));
            animation: loadSlide 1.4s ease-in-out infinite;
        }
        @keyframes loadSlide {
            0%   { width: 0%; margin-left: 0%; }
            50%  { width: 60%; margin-left: 20%; }
            100% { width: 0%; margin-left: 100%; }
        }

        /* ─── Results ────────────────────────────────────────────────────── */
        .results-container { max-width: 680px; margin: 1.5rem auto 0; }
        .results-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 0.85rem; flex-wrap: wrap; gap: 0.5rem;
        }
        .count-badge {
            background: var(--red-600); color: var(--white);
            font-size: 0.78rem; font-weight: 700;
            padding: 0.12rem 0.5rem; border-radius: 100px; margin-right: 0.25rem;
        }
        .results-count { font-size: 0.88rem; font-weight: 600; color: var(--gray-600); }
        .results-page-info { font-size: 0.78rem; color: var(--gray-400); }

        /* Voter card */
        .results-list { display: flex; flex-direction: column; gap: 0.6rem; }
        .voter-card {
            background: var(--white); border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            padding: 0.9rem 1.1rem;
            display: flex; align-items: center; gap: 0.85rem;
            transition: box-shadow 0.2s, transform 0.15s, border-color 0.2s;
        }
        .voter-card:hover { box-shadow: var(--shadow-md); transform: translateY(-1px); border-color: var(--red-200); }
        .voter-card-left { display: flex; align-items: center; gap: 0.7rem; flex-shrink: 0; }
        .voter-serial { font-size: 0.68rem; font-weight: 700; color: var(--gray-300); min-width: 22px; text-align: right; }
        .voter-avatar {
            width: 42px; height: 42px; border-radius: 50%;
            background: linear-gradient(135deg, var(--red-600), var(--red-400));
            color: var(--white); font-size: 1rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .voter-card-body { flex: 1; min-width: 0; }
        .voter-name { font-size: 0.95rem; font-weight: 700; color: var(--gray-800); margin-bottom: 0.2rem; }
        .voter-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 0.45rem; }
        .voter-branch, .voter-reg {
            display: flex; align-items: center; gap: 0.25rem;
            font-size: 0.73rem; color: var(--gray-600);
            background: var(--gray-100); padding: 0.15rem 0.5rem; border-radius: 100px;
        }
        .meta-icon { width: 10px; height: 10px; }
        .voter-card-actions { display: flex; gap: 0.45rem; flex-shrink: 0; flex-wrap: wrap; }
        .btn-slip, .btn-share {
            display: flex; align-items: center; gap: 0.3rem;
            padding: 0.42rem 0.7rem; border-radius: var(--radius-sm);
            font-size: 0.73rem; font-weight: 700;
            text-decoration: none; transition: filter 0.15s, transform 0.12s; white-space: nowrap;
        }
        .btn-slip { background: linear-gradient(135deg, var(--red-700), var(--red-500)); color: var(--white); }
        .btn-share { background: var(--gray-100); color: var(--gray-700); border: 1px solid var(--gray-200); }
        .btn-slip:hover, .btn-share:hover { filter: brightness(1.07); transform: translateY(-1px); }
        .btn-icon-sm { width: 12px; height: 12px; }

        /* No results */
        .no-results {
            text-align: center; padding: 3rem 1.5rem;
            background: var(--white); border-radius: var(--radius-xl);
            box-shadow: var(--shadow-sm); margin-top: 1.5rem;
            max-width: 680px; margin-left: auto; margin-right: auto;
        }
        .no-results-icon { width: 50px; height: 50px; color: var(--gray-300); margin: 0 auto 1rem; }
        .no-results h3 { font-size: 1.05rem; font-weight: 700; margin-bottom: 0.4rem; }
        .no-results p { font-size: 0.85rem; color: var(--gray-500); }

        /* Pagination */
        .pagination-wrapper { margin-top: 1.5rem; display: flex; justify-content: center; }
        .pagination { display: flex; gap: 0.3rem; align-items: center; list-style: none; flex-wrap: wrap; }
        .pagination span, .pagination a {
            padding: 0.4rem 0.7rem; border-radius: var(--radius-sm);
            font-size: 0.8rem; font-weight: 600;
            border: 1px solid var(--gray-200); color: var(--gray-600);
            text-decoration: none; display: block;
        }
        .pagination a:hover { background: var(--red-50); border-color: var(--red-200); color: var(--red-700); }
        .pagination .active span { background: var(--red-600); border-color: var(--red-600); color: var(--white); }
        .pagination .disabled span { color: var(--gray-300); background: var(--gray-50); }

        /* ─── Footer ─────────────────────────────────────────────────────── */
        .site-footer {
            background: var(--gray-900); color: rgba(255,255,255,0.5);
            text-align: center; padding: 1.1rem; font-size: 0.75rem; margin-top: 3rem;
        }
        .site-footer a { color: var(--red-400); text-decoration: none; }

        /* ─── Admin styles ───────────────────────────────────────────────── */
        .admin-nav {
            background: var(--gray-900); padding: 0.7rem 1.5rem;
            display: flex; align-items: center; justify-content: space-between;
        }
        .admin-nav-brand { color: var(--red-400); font-weight: 800; font-size: 0.88rem; }
        .admin-nav a { color: rgba(255,255,255,0.65); font-size: 0.8rem; text-decoration: none; }
        .admin-nav a:hover { color: var(--white); }
        .admin-import-wrap { max-width: 600px; margin: 2rem auto; padding: 0 1rem; }
        .admin-card { background: var(--white); border-radius: var(--radius-xl); box-shadow: var(--shadow-xl); overflow: hidden; }
        .admin-card-header {
            background: linear-gradient(135deg, var(--red-700), var(--red-500));
            padding: 1.5rem; display: flex; gap: 1rem;
            align-items: flex-start; color: var(--white);
        }
        .admin-icon { width: 38px; height: 38px; color: rgba(255,255,255,0.8); flex-shrink: 0; margin-top: 2px; }
        .admin-card-header h2 { font-size: 1.1rem; font-weight: 800; margin-bottom: 0.2rem; }
        .admin-card-header p { font-size: 0.8rem; opacity: 0.8; }
        .admin-stats { padding: 1rem 1.5rem; background: var(--gray-50); border-bottom: 1px solid var(--gray-200); }
        .stat-item { display: flex; flex-direction: column; }
        .stat-value { font-size: 1.8rem; font-weight: 900; color: var(--red-600); line-height: 1; }
        .stat-label { font-size: 0.72rem; color: var(--gray-400); font-weight: 600; text-transform: uppercase; letter-spacing: 0.08em; margin-top: 0.15rem; }
        .import-form { padding: 1.5rem; display: flex; flex-direction: column; gap: 1.1rem; }
        .file-upload-label {
            display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.5rem;
            border: 2px dashed var(--gray-200); border-radius: var(--radius-lg);
            padding: 2rem; cursor: pointer;
            transition: border-color 0.2s, background 0.2s; background: var(--gray-50);
        }
        .file-upload-label:hover, .file-upload-label.dragging { border-color: var(--red-400); background: var(--red-50); }
        .upload-icon { width: 38px; height: 38px; color: var(--red-400); }
        .upload-text { font-size: 0.88rem; font-weight: 600; color: var(--gray-600); }
        .upload-subtext { font-size: 0.76rem; color: var(--gray-400); }
        .upload-filename { font-size: 0.86rem; font-weight: 700; color: var(--red-700); }
        .upload-size { font-size: 0.73rem; color: var(--gray-400); }
        .hidden-input { display: none; }
        .checkbox-label { display: flex; align-items: center; gap: 0.6rem; font-size: 0.83rem; color: var(--gray-600); cursor: pointer; }
        .checkbox-input { width: 15px; height: 15px; accent-color: var(--red-600); cursor: pointer; }
        .format-hint {
            background: #fffbeb; border: 1px solid #fde68a;
            border-radius: var(--radius-md); padding: 0.65rem 1rem;
            font-size: 0.76rem; color: #92400e;
        }
        .btn-import {
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            padding: 0.9rem 1.5rem;
            background: linear-gradient(135deg, var(--red-700), var(--red-500));
            color: var(--white); border: none; border-radius: var(--radius-md);
            font-size: 0.92rem; font-weight: 700; cursor: pointer; font-family: inherit;
            transition: filter 0.15s;
        }
        .btn-import:hover:not([disabled]) { filter: brightness(1.07); }
        .btn-import[disabled] { opacity: 0.6; cursor: not-allowed; }

        /* ─── Responsive ─────────────────────────────────────────────────── */
        @media (max-width: 580px) {
            .hero-candidate { flex-direction: column; align-items: flex-start; }
            .hero-top { justify-content: center; }
            .hero-logo-left, .hero-logo-right { display: none; }
            .numbers-strip { justify-content: center; }
            .voter-card { flex-direction: column; align-items: flex-start; }
            .voter-card-actions { align-self: stretch; }
            .btn-slip, .btn-share { flex: 1; justify-content: center; }
        }
    </style>
    @yield('extra-styles')
</head>
<body>
<div class="page-wrap">
    @yield('content')
    <footer class="site-footer">
        MMC Elections 2026 — Voter Search Portal &nbsp;|&nbsp;
        <a href="{{ route('admin.dashboard') }}">Admin</a>
    </footer>
</div>
@livewireScripts
@yield('extra-scripts')
</body>
</html>

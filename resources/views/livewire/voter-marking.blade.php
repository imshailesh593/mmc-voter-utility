<div>
    {{-- Branch selector --}}
    <div class="vm-branch-bar">
        <div class="vm-branch-label">Select Branch</div>
        <div class="vm-branch-list">
            @foreach($branches as $b)
                <button
                    type="button"
                    wire:click="$set('branch', '{{ $b }}')"
                    class="vm-branch-btn {{ $branch === $b ? 'vm-branch-btn--active' : '' }}"
                >{{ $b }}</button>
            @endforeach
        </div>
    </div>

    @if($branch)
        {{-- Stats row --}}
        @if($stats)
        <div class="vm-stats">
            <div class="vm-stat">
                <div class="vm-stat-val">{{ $stats['total'] }}</div>
                <div class="vm-stat-label">Total</div>
            </div>
            <div class="vm-stat vm-stat--blue">
                <div class="vm-stat-val">{{ $stats['voted'] }}</div>
                <div class="vm-stat-label">Voted</div>
            </div>
            <div class="vm-stat vm-stat--green">
                <div class="vm-stat-val">{{ $stats['in_favour'] }}</div>
                <div class="vm-stat-label">In Favour</div>
            </div>
            <div class="vm-stat vm-stat--red">
                <div class="vm-stat-val">{{ $stats['against'] }}</div>
                <div class="vm-stat-label">Against</div>
            </div>
            @if($stats['voted'] > 0)
            <div class="vm-stat vm-stat--gray">
                <div class="vm-stat-val">{{ round($stats['voted'] / max($stats['total'],1) * 100) }}%</div>
                <div class="vm-stat-label">Turnout</div>
            </div>
            @endif
        </div>
        @endif

        {{-- Search + filter --}}
        <div class="vm-toolbar">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search name or reg no…"
                class="vm-search-input"
            >
            <div class="vm-filter-tabs">
                <button type="button" wire:click="$set('filter','all')"       class="vm-tab {{ $filter==='all'       ? 'vm-tab--active' : '' }}">All</button>
                <button type="button" wire:click="$set('filter','voted')"     class="vm-tab {{ $filter==='voted'     ? 'vm-tab--active' : '' }}">Voted</button>
                <button type="button" wire:click="$set('filter','not_voted')" class="vm-tab {{ $filter==='not_voted' ? 'vm-tab--active vm-tab--pending' : '' }}">Not Voted</button>
            </div>
        </div>

        <div wire:loading.delay class="vm-loading-bar"><div class="vm-loading-inner"></div></div>

        @if($voters && $voters->total() > 0)
            {{-- Column headers --}}
            <div class="vm-list-header">
                <span class="vmh-name">Voter</span>
                <span class="vmh-voted">Voted?</span>
                <span class="vmh-favour">In Favour?</span>
            </div>

            <div class="vm-list">
                @foreach($voters as $voter)
                <div class="vm-row {{ $voter->voted ? 'vm-row--voted' : '' }}">
                    <div class="vm-row-info">
                        <div class="vm-voter-avatar">{{ mb_strtoupper(mb_substr($voter->name, 0, 1)) }}</div>
                        <div class="vm-voter-details">
                            <div class="vm-voter-name">{{ $voter->name }}</div>
                            <div class="vm-voter-meta">
                                @if($voter->registration_number)
                                    <span>Reg: {{ $voter->registration_number }}</span>
                                @endif
                                @if($voter->serial_number)
                                    <span>Sr: {{ $voter->serial_number }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Voted toggle --}}
                    <div class="vm-col-voted">
                        <button
                            type="button"
                            wire:click="toggleVoted({{ $voter->id }})"
                            class="vm-toggle {{ $voter->voted ? 'vm-toggle--on' : 'vm-toggle--off' }}"
                            title="{{ $voter->voted ? 'Mark as NOT voted' : 'Mark as voted' }}"
                        >
                            @if($voter->voted)
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                Voted
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                No
                            @endif
                        </button>
                    </div>

                    {{-- In Favour --}}
                    <div class="vm-col-favour">
                        @if($voter->voted)
                            <button
                                type="button"
                                wire:click="setInFavour({{ $voter->id }}, true)"
                                class="vm-favour-btn {{ $voter->in_favour === true ? 'vm-favour-btn--yes' : '' }}"
                                title="In Favour"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg>
                                Yes
                            </button>
                            <button
                                type="button"
                                wire:click="setInFavour({{ $voter->id }}, false)"
                                class="vm-favour-btn {{ $voter->in_favour === false ? 'vm-favour-btn--no' : '' }}"
                                title="Against"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 3h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.095c.5 0 .905-.405.905-.905 0-.714.211-1.412.608-2.006L17 13V4m-7 10h2m5-10h2a2 2 0 012 2v6a2 2 0 01-2 2h-2.5"/></svg>
                                No
                            </button>
                        @else
                            <span class="vm-favour-na">—</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            @if($voters->lastPage() > 1)
                <div class="vm-pagination">
                    {{ $voters->links() }}
                </div>
            @endif

        @elseif($voters)
            <div class="vm-empty">No voters found for the current filter.</div>
        @endif

    @else
        <div class="vm-pick-branch">
            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="color:var(--gray-300);margin-bottom:0.75rem"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <p>Select a branch above to start marking voters</p>
        </div>
    @endif

    <style>
        /* Branch bar */
        .vm-branch-bar { margin-bottom: 1.25rem; }
        .vm-branch-label { font-size: 0.72rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: var(--gray-400); margin-bottom: 0.55rem; }
        .vm-branch-list { display: flex; flex-wrap: wrap; gap: 0.45rem; }
        .vm-branch-btn {
            padding: 0.4rem 0.85rem; border-radius: 100px;
            font-size: 0.8rem; font-weight: 600;
            border: 2px solid var(--gray-200); background: var(--white); color: var(--gray-600);
            cursor: pointer; transition: all 0.15s; font-family: inherit;
        }
        .vm-branch-btn:hover { border-color: var(--red-300); color: var(--red-700); background: var(--red-50); }
        .vm-branch-btn--active { background: var(--red-600); border-color: var(--red-600); color: var(--white); }

        /* Stats */
        .vm-stats {
            display: flex; gap: 0.65rem; flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }
        .vm-stat {
            flex: 1; min-width: 70px;
            background: var(--white); border: 1px solid var(--gray-200);
            border-radius: var(--radius-lg); padding: 0.75rem 1rem;
            text-align: center;
        }
        .vm-stat--blue  { border-color: #bfdbfe; background: #eff6ff; }
        .vm-stat--green { border-color: #bbf7d0; background: #f0fdf4; }
        .vm-stat--red   { border-color: var(--red-200); background: var(--red-50); }
        .vm-stat--gray  { border-color: var(--gray-200); background: var(--gray-50); }
        .vm-stat-val   { font-size: 1.5rem; font-weight: 900; color: var(--gray-800); line-height: 1; }
        .vm-stat--blue  .vm-stat-val { color: #1d4ed8; }
        .vm-stat--green .vm-stat-val { color: #15803d; }
        .vm-stat--red   .vm-stat-val { color: var(--red-600); }
        .vm-stat-label { font-size: 0.65rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.07em; color: var(--gray-400); margin-top: 0.2rem; }

        /* Toolbar */
        .vm-toolbar { display: flex; gap: 0.75rem; align-items: center; margin-bottom: 0.85rem; flex-wrap: wrap; }
        .vm-search-input {
            flex: 1; min-width: 180px;
            padding: 0.55rem 0.9rem; border: 2px solid var(--gray-200);
            border-radius: var(--radius-md); font-size: 0.85rem; font-family: inherit;
            background: var(--white); color: var(--gray-800); outline: none;
            transition: border-color 0.2s;
        }
        .vm-search-input:focus { border-color: var(--red-400); }
        .vm-filter-tabs { display: flex; gap: 0.3rem; }
        .vm-tab {
            padding: 0.4rem 0.85rem; border-radius: 100px;
            font-size: 0.78rem; font-weight: 600;
            border: 2px solid var(--gray-200); background: var(--white); color: var(--gray-500);
            cursor: pointer; font-family: inherit; transition: all 0.15s;
        }
        .vm-tab--active { background: var(--gray-800); border-color: var(--gray-800); color: var(--white); }
        .vm-tab--pending.vm-tab--active { background: var(--red-600); border-color: var(--red-600); }

        /* Loading */
        .vm-loading-bar { height: 3px; background: var(--gray-100); overflow: hidden; margin-bottom: 0.5rem; border-radius: 2px; }
        .vm-loading-inner { height: 100%; background: linear-gradient(90deg, var(--red-500), var(--salmon)); animation: loadSlide 1.4s ease-in-out infinite; }

        /* List header */
        .vm-list-header {
            display: grid; grid-template-columns: 1fr 90px 140px;
            padding: 0.35rem 0.9rem; font-size: 0.65rem; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.08em; color: var(--gray-400);
            border-bottom: 1px solid var(--gray-200); margin-bottom: 0.4rem;
        }
        .vmh-voted, .vmh-favour { text-align: center; }

        /* Rows */
        .vm-list { display: flex; flex-direction: column; gap: 0.3rem; }
        .vm-row {
            display: grid; grid-template-columns: 1fr 90px 140px;
            align-items: center;
            background: var(--white); border: 1px solid var(--gray-200);
            border-radius: var(--radius-md); padding: 0.6rem 0.9rem;
            transition: border-color 0.15s;
        }
        .vm-row--voted { border-left: 3px solid #22c55e; }
        .vm-row-info { display: flex; align-items: center; gap: 0.65rem; min-width: 0; }
        .vm-voter-avatar {
            width: 34px; height: 34px; border-radius: 50%; flex-shrink: 0;
            background: linear-gradient(135deg, var(--red-600), var(--red-400));
            color: var(--white); font-size: 0.85rem; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
        }
        .vm-voter-details { min-width: 0; }
        .vm-voter-name { font-size: 0.875rem; font-weight: 700; color: var(--gray-800); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .vm-voter-meta { display: flex; gap: 0.5rem; font-size: 0.68rem; color: var(--gray-400); flex-wrap: wrap; }

        /* Voted toggle */
        .vm-col-voted { display: flex; justify-content: center; }
        .vm-toggle {
            display: inline-flex; align-items: center; gap: 0.3rem;
            padding: 0.32rem 0.65rem; border-radius: 100px;
            font-size: 0.72rem; font-weight: 700; cursor: pointer; border: none;
            font-family: inherit; transition: all 0.15s;
        }
        .vm-toggle--on  { background: #dcfce7; color: #15803d; }
        .vm-toggle--off { background: var(--gray-100); color: var(--gray-400); }
        .vm-toggle--on:hover  { background: #bbf7d0; }
        .vm-toggle--off:hover { background: var(--gray-200); }

        /* In favour */
        .vm-col-favour { display: flex; justify-content: center; gap: 0.35rem; }
        .vm-favour-btn {
            display: inline-flex; align-items: center; gap: 0.25rem;
            padding: 0.3rem 0.6rem; border-radius: 100px;
            font-size: 0.7rem; font-weight: 700; cursor: pointer;
            border: 2px solid var(--gray-200); background: var(--white); color: var(--gray-400);
            font-family: inherit; transition: all 0.15s;
        }
        .vm-favour-btn:hover { border-color: var(--gray-300); color: var(--gray-600); }
        .vm-favour-btn--yes { background: #dcfce7; border-color: #86efac; color: #15803d; }
        .vm-favour-btn--no  { background: var(--red-50); border-color: var(--red-200); color: var(--red-600); }
        .vm-favour-na { color: var(--gray-300); font-size: 0.85rem; display: block; text-align: center; }

        /* Empty + pick */
        .vm-empty, .vm-pick-branch {
            text-align: center; padding: 3rem 1rem;
            background: var(--white); border-radius: var(--radius-lg);
            border: 1px solid var(--gray-200);
            color: var(--gray-500); font-size: 0.9rem; font-weight: 500;
        }
        .vm-pick-branch { display: flex; flex-direction: column; align-items: center; }

        /* Pagination */
        .vm-pagination { margin-top: 1.25rem; display: flex; justify-content: center; }

        @media (max-width: 540px) {
            .vm-list-header { grid-template-columns: 1fr 72px 120px; }
            .vm-row          { grid-template-columns: 1fr 72px 120px; }
        }
    </style>
</div>

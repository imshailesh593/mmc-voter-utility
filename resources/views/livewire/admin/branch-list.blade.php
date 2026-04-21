<div>
    @if($successMessage)
        <div class="alert alert-success" style="margin-bottom:1rem">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $successMessage }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <span class="card-title">{{ $branches->count() }} Branches &nbsp;·&nbsp; {{ number_format($grandTotal) }} Total Voters</span>
            <input
                type="text"
                wire:model.live.debounce.250ms="search"
                class="toolbar-input"
                placeholder="Filter branches…"
            >
        </div>

        <div wire:loading class="loading-bar"><div class="loading-bar-fill"></div></div>

        <div class="card-body">
            @if($branches->count() > 0)
                <div class="branch-grid">
                    @foreach($branches as $b)
                        <div class="branch-card">
                            <div>
                                <div class="branch-card-name">{{ $b->branch }}</div>
                                <div class="branch-card-count">{{ number_format($b->total) }} voters &nbsp;·&nbsp; {{ $grandTotal > 0 ? round($b->total / $grandTotal * 100, 1) : 0 }}%</div>
                            </div>
                            <div style="display:flex;align-items:center;gap:0.5rem">
                                <span class="branch-card-num">{{ number_format($b->total) }}</span>
                                <button wire:click="confirmDelete('{{ $b->branch }}')" class="btn btn-danger btn-sm" title="Delete branch">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    <h3>No branches found</h3>
                    <p>No branches match your filter.</p>
                </div>
            @endif
        </div>
    </div>

    @if($confirmDeleteBranch)
        <div class="confirm-overlay">
            <div class="confirm-box">
                <h3>Delete Branch "{{ $confirmDeleteBranch }}"?</h3>
                <p>All voters in this branch will be permanently deleted. This cannot be undone.</p>
                <div class="confirm-actions">
                    <button wire:click="cancelDelete" class="btn btn-ghost">Cancel</button>
                    <button wire:click="deleteBranch" class="btn btn-danger">Yes, Delete All</button>
                </div>
            </div>
        </div>
    @endif
</div>

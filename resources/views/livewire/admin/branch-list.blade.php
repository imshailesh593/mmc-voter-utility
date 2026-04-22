<div>
    @if($successMessage)
        <div class="alert alert-success" style="margin-bottom:1rem">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $successMessage }}
        </div>
    @endif

    @if($errorMessage)
        <div class="alert alert-error" style="margin-bottom:1rem">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $errorMessage }}
        </div>
    @endif

    {{-- Venue bulk upload --}}
    @if($showVenueUpload)
        <div class="card" style="margin-bottom:1rem;border:2px dashed var(--red-200)">
            <div class="card-header" style="background:var(--red-50)">
                <span class="card-title" style="color:var(--red-700)">Bulk Upload Voting Centres</span>
                <button wire:click="$set('showVenueUpload',false)" class="btn btn-ghost btn-sm">Cancel</button>
            </div>
            <div style="padding:1.25rem">
                <div style="font-size:0.78rem;color:var(--gray-500);margin-bottom:1rem;background:var(--gray-50);border:1px solid var(--gray-200);border-radius:8px;padding:0.65rem 0.9rem">
                    Expected columns: <strong>Sr. No.</strong> &nbsp;·&nbsp; <strong>Branch</strong> &nbsp;·&nbsp; <strong>Location of Polling Station</strong>
                </div>
                <div style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap">
                    <label style="flex:1;min-width:200px">
                        <input type="file" wire:model="venueFile" accept=".xlsx,.xls,.csv"
                            style="width:100%;padding:0.5rem;border:2px solid var(--gray-200);border-radius:8px;font-size:0.83rem;font-family:inherit;cursor:pointer">
                    </label>
                    <button wire:click="importVenues" class="btn btn-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="importVenues">Import Venues</span>
                        <span wire:loading wire:target="importVenues">Importing…</span>
                    </button>
                </div>
                @error('venueFile') <div style="font-size:0.75rem;color:var(--red-600);margin-top:0.4rem">{{ $message }}</div> @enderror
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <div style="display:flex;flex-direction:column;gap:0.1rem">
                <span class="card-title">{{ $branches->count() }} Branches &nbsp;·&nbsp; {{ number_format($grandTotal) }} Total Voters</span>
                <span style="font-size:0.7rem;color:var(--gray-400)">{{ count($venues) }} venues configured</span>
            </div>
            <div style="display:flex;align-items:center;gap:0.5rem">
                <button wire:click="$set('showVenueUpload',true)" class="btn btn-ghost btn-sm" style="white-space:nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:13px;height:13px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    Upload Venues
                </button>
                <input type="text" wire:model.live.debounce.250ms="search" class="toolbar-input" placeholder="Filter branches…">
            </div>
        </div>

        <div wire:loading class="loading-bar"><div class="loading-bar-fill"></div></div>

        <div class="card-body" style="padding:0">
            @if($branches->count() > 0)
                <table class="bl-table">
                    <thead>
                        <tr>
                            <th style="width:22%">Branch</th>
                            <th style="width:12%">Voters</th>
                            <th>Polling Station / Venue</th>
                            <th style="width:80px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($branches as $b)
                            @php $branchKey = strtolower(trim($b->branch)); @endphp
                            <tr class="bl-row">
                                <td>
                                    <div class="bl-branch-name">{{ $b->branch }}</div>
                                </td>
                                <td>
                                    <span class="bl-count">{{ number_format($b->total) }}</span>
                                    <span class="bl-pct">{{ $grandTotal > 0 ? round($b->total / $grandTotal * 100, 1) : 0 }}%</span>
                                </td>
                                <td>
                                    @if(isset($venues[$branchKey]))
                                        <div class="bl-venue" title="{{ $venues[$branchKey] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="flex-shrink:0;color:var(--red-400)"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                            <span>{{ $venues[$branchKey] }}</span>
                                        </div>
                                    @else
                                        <span class="bl-no-venue">— not set</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display:flex;justify-content:flex-end;gap:0.3rem">
                                        <button wire:click="openVenueEdit('{{ addslashes($b->branch) }}')" class="btn btn-ghost btn-sm" title="Edit venue">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </button>
                                        <button wire:click="confirmDelete('{{ addslashes($b->branch) }}')" class="btn btn-danger btn-sm" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:12px;height:12px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty" style="padding:3rem">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    <h3>No branches found</h3>
                    <p>No branches match your filter.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Venue edit modal --}}
    @if($editingVenueBranch)
        <div class="confirm-overlay">
            <div class="confirm-box" style="max-width:500px">
                <h3 style="margin-bottom:0.25rem">Edit Polling Station</h3>
                <p style="font-size:0.8rem;color:var(--gray-500);margin-bottom:1rem">Branch: <strong>{{ $editingVenueBranch }}</strong></p>
                <textarea
                    wire:model="editingVenueValue"
                    rows="3"
                    placeholder="Enter venue / polling station address… (leave blank to remove)"
                    style="width:100%;padding:0.65rem 0.85rem;border:2px solid var(--gray-200);border-radius:8px;font-size:0.85rem;font-family:inherit;resize:vertical;outline:none;transition:border-color 0.2s"
                    onfocus="this.style.borderColor='var(--red-400)'"
                    onblur="this.style.borderColor='var(--gray-200)'"
                ></textarea>
                <div style="font-size:0.72rem;color:var(--gray-400);margin-top:0.4rem;margin-bottom:1rem">
                    Leave blank to revert to "District Headquarter" for this branch.
                </div>
                <div class="confirm-actions">
                    <button wire:click="cancelVenueEdit" class="btn btn-ghost">Cancel</button>
                    <button wire:click="saveVenue" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    @endif

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

    <style>
        .bl-table { width:100%; border-collapse:collapse; font-size:0.82rem; }
        .bl-table thead tr { border-bottom:2px solid var(--gray-200); }
        .bl-table th {
            padding:0.6rem 1rem; text-align:left;
            font-size:0.65rem; font-weight:700; text-transform:uppercase;
            letter-spacing:0.08em; color:var(--gray-400);
        }
        .bl-row { border-bottom:1px solid var(--gray-100); transition:background 0.1s; }
        .bl-row:last-child { border-bottom:none; }
        .bl-row:hover { background:var(--gray-50); }
        .bl-row td { padding:0.7rem 1rem; vertical-align:middle; }
        .bl-branch-name { font-weight:700; color:var(--gray-800); font-size:0.83rem; }
        .bl-count { font-weight:700; color:var(--gray-700); }
        .bl-pct { font-size:0.72rem; color:var(--gray-400); margin-left:0.3rem; }
        .bl-venue {
            display:flex; align-items:flex-start; gap:5px;
            color:var(--gray-600); line-height:1.4;
            overflow:hidden;
        }
        .bl-venue span {
            display:-webkit-box; -webkit-line-clamp:2;
            -webkit-box-orient:vertical; overflow:hidden;
        }
        .bl-no-venue { color:var(--gray-300); font-style:italic; font-size:0.78rem; }
        .btn-primary {
            background:var(--red-600); color:#fff; border:none;
            padding:0.5rem 1.1rem; border-radius:7px;
            font-size:0.85rem; font-weight:600; cursor:pointer;
            font-family:inherit; transition:filter 0.15s;
        }
        .btn-primary:hover { filter:brightness(1.08); }
    </style>
</div>

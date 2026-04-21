<div>
    {{-- Success message --}}
    @if($successMessage)
        <div class="alert alert-success" style="margin-bottom:1rem">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ $successMessage }}
        </div>
    @endif

    <div class="card">
        {{-- Toolbar --}}
        <div class="card-header">
            <div class="toolbar" style="flex:1">
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    class="toolbar-input wide"
                    placeholder="Search name or mobile…"
                >
                <select wire:model.live="branch" class="toolbar-select">
                    <option value="">All Branches</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->branch }}">{{ $b->branch }} ({{ number_format($b->total) }})</option>
                    @endforeach
                </select>
                @if($branch)
                    <button wire:click="confirmDeleteBranch('{{ $branch }}')" class="btn btn-danger btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Delete Branch
                    </button>
                @endif
                @if($search || $branch)
                    <button wire:click="$set('search', ''); $set('branch', '')" class="btn btn-ghost btn-sm">Clear</button>
                @endif
                <div class="toolbar-spacer"></div>
                <span style="font-size:0.75rem;color:var(--gray-400)">
                    {{ number_format($voters->total()) }} voter{{ $voters->total() === 1 ? '' : 's' }}
                </span>
            </div>
        </div>

        {{-- Loading bar --}}
        <div wire:loading class="loading-bar"><div class="loading-bar-fill"></div></div>

        {{-- Table --}}
        <div class="table-wrap">
            @if($voters->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Branch</th>
                            <th>Mobile</th>
                            <th>Reg. No.</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($voters as $voter)
                            <tr>
                                <td style="color:var(--gray-300);font-size:0.72rem">{{ $voter->id }}</td>
                                <td class="td-name">{{ $voter->name }}</td>
                                <td><span class="td-badge">{{ $voter->branch ?: '—' }}</span></td>
                                <td style="font-family:monospace;font-size:0.8rem">{{ $voter->phone ?: '—' }}</td>
                                <td style="font-size:0.78rem;color:var(--gray-500)">{{ $voter->registration_number ?: '—' }}</td>
                                <td>
                                    <div class="td-actions">
                                        <a href="{{ route('slip.share', $voter->id) }}" target="_blank" class="btn btn-ghost btn-sm">Slip</a>
                                        <button wire:click="confirmDelete({{ $voter->id }})" class="btn btn-danger btn-sm">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3>No voters found</h3>
                    <p>Try adjusting your search or branch filter.</p>
                </div>
            @endif
        </div>

        {{-- Pagination --}}
        @if($voters->lastPage() > 1)
            <div class="pag-wrap">
                <span class="pag-info">
                    Showing {{ $voters->firstItem() }}–{{ $voters->lastItem() }} of {{ number_format($voters->total()) }}
                </span>
                {{ $voters->links() }}
            </div>
        @endif
    </div>

    {{-- Delete single voter confirm --}}
    @if($confirmDeleteId)
        <div class="confirm-overlay">
            <div class="confirm-box">
                <h3>Delete Voter?</h3>
                <p>This will permanently remove the voter from the database. This cannot be undone.</p>
                <div class="confirm-actions">
                    <button wire:click="cancelDelete" class="btn btn-ghost">Cancel</button>
                    <button wire:click="deleteVoter" class="btn btn-danger">Yes, Delete</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete branch confirm --}}
    @if($confirmDeleteBranch)
        <div class="confirm-overlay">
            <div class="confirm-box">
                <h3>Delete Entire Branch?</h3>
                <p>This will permanently delete <strong>all voters</strong> in branch <strong>{{ $confirmDeleteBranch }}</strong>. This cannot be undone.</p>
                <div class="confirm-actions">
                    <button wire:click="cancelDelete" class="btn btn-ghost">Cancel</button>
                    <button wire:click="deleteBranch" class="btn btn-danger">Yes, Delete All</button>
                </div>
            </div>
        </div>
    @endif
</div>

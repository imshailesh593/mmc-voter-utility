<div>
    <form wire:submit="search" class="search-form">
        <div class="form-group">
            <label class="form-label" for="phone-input">
                Mobile Number
            </label>
            <input
                id="phone-input"
                type="tel"
                wire:model="phone"
                class="form-input"
                placeholder="Enter mobile number..."
                inputmode="numeric"
                autocomplete="off"
            >
        </div>

        <div class="divider-or">OR</div>

        <div class="form-group">
            <label class="form-label" for="name-input">
                Full Name
            </label>
            <input
                id="name-input"
                type="text"
                wire:model="name"
                class="form-input"
                placeholder="Enter voter name..."
                autocomplete="off"
            >
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-search" wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <span wire:loading>
                    <svg class="btn-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="animation:spin 1s linear infinite">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </span>
                Search
            </button>
            @if($searched)
                <button type="button" wire:click="clear" class="btn-clear">Clear</button>
            @endif
        </div>
    </form>

    <div wire:loading class="loading-bar" style="margin-top:0.75rem">
        <div class="loading-bar-inner"></div>
    </div>

    @if($searched)
        @if($voters && $voters->total() > 0)
            <div class="results-container">
                <div class="results-header">
                    <div class="results-count">
                        <span class="count-badge">{{ $voters->total() }}</span>
                        {{ $voters->total() === 1 ? 'voter found' : 'voters found' }}
                    </div>
                    @if($voters->lastPage() > 1)
                        <div class="results-page-info">Page {{ $voters->currentPage() }} of {{ $voters->lastPage() }}</div>
                    @endif
                </div>

                <div class="results-list">
                    @foreach($voters as $index => $voter)
                        <div class="voter-card">
                            <div class="voter-card-left">
                                <span class="voter-serial">{{ ($voters->currentPage() - 1) * $voters->perPage() + $loop->iteration }}</span>
                                <div class="voter-avatar">{{ mb_strtoupper(mb_substr($voter->name, 0, 1)) }}</div>
                            </div>
                            <div class="voter-card-body">
                                <div class="voter-name">{{ $voter->name }}</div>
                                <div class="voter-meta">
                                    @if($voter->branch)
                                        <span class="voter-branch">
                                            <svg class="meta-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $voter->branch }}
                                        </span>
                                    @endif
                                    @if($voter->registration_number)
                                        <span class="voter-reg">
                                            <svg class="meta-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            {{ $voter->registration_number }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="voter-card-actions">
                                <a href="{{ route('slip.share', $voter->id) }}" class="btn-slip">
                                    <svg class="btn-icon-sm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    View Slip
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if($voters->lastPage() > 1)
                    <div class="pagination-wrapper">
                        {{ $voters->links() }}
                    </div>
                @endif
            </div>
        @elseif($voters)
            <div class="no-results">
                <svg class="no-results-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3>No voters found</h3>
                <p>Try a different name or mobile number.</p>
            </div>
        @endif
    @endif

    <style>
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</div>

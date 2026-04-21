<?php

use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Voter;

new class extends Component
{
    use WithPagination;

    public string $phone = '';
    public string $name = '';
    public string $registration = '';
    public bool $searched = false;

    protected $messages = [
        'phone.digits_between' => 'Please enter a valid mobile number (8-15 digits).',
    ];

    public function search(): void
    {
        $this->validate([
            'phone'        => 'nullable|digits_between:8,15',
            'name'         => 'nullable|string|max:100',
            'registration' => 'nullable|string|max:50',
        ]);

        if (empty($this->phone) && empty($this->name) && empty($this->registration)) {
            $this->addError('general', 'Please enter at least one search field.');
            return;
        }

        $this->resetPage();
        $this->searched = true;
    }

    public function clearSearch(): void
    {
        $this->reset(['phone', 'name', 'registration', 'searched']);
        $this->resetErrorBag();
        $this->resetPage();
    }

    #[Computed]
    public function voters()
    {
        if (!$this->searched) {
            return null;
        }
        return Voter::search($this->phone, $this->name, $this->registration)->paginate(20);
    }
};
?>

<div>
    {{-- Search Form --}}
    <form wire:submit="search" class="search-form">
        @if($errors->has('general'))
            <div class="alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="alert-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $errors->first('general') }}
            </div>
        @endif

        <div class="form-group">
            <label class="form-label">
                Mobile Number (Mandatory) <span class="required-star">*</span>
            </label>
            <input
                type="tel"
                wire:model="phone"
                class="form-input @error('phone') input-error @enderror"
                placeholder="e.g., 9876543210"
                maxlength="15"
            >
            @error('phone')
                <span class="field-error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-label">Voter Name</label>
            <input
                type="text"
                wire:model="name"
                class="form-input"
                placeholder="Enter keywords separated by space"
            >
        </div>

        <div class="divider-or">
            <span>OR</span>
        </div>

        <div class="form-group">
            <label class="form-label">Registration Number</label>
            <input
                type="text"
                wire:model="registration"
                class="form-input"
                placeholder="Enter Exact Registration Number"
            >
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-search">
                <svg xmlns="http://www.w3.org/2000/svg" class="btn-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span wire:loading.remove wire:target="search">Search Database</span>
                <span wire:loading wire:target="search">Searching...</span>
            </button>
            @if($searched)
            <button type="button" wire:click="clearSearch" class="btn-clear">
                Clear
            </button>
            @endif
        </div>
    </form>

    {{-- Loading indicator --}}
    <div wire:loading wire:target="search" class="loading-bar">
        <div class="loading-bar-inner"></div>
    </div>

    {{-- Results Section --}}
    @if($searched)
        @php $voters = $this->voters(); @endphp

        @if(!$voters || $voters->isEmpty())
            <div class="no-results">
                <svg xmlns="http://www.w3.org/2000/svg" class="no-results-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3>No voters found</h3>
                <p>No records matched your search. Please try different keywords or contact your branch representative.</p>
            </div>
        @else
            <div class="results-header">
                <div class="results-count">
                    <span class="count-badge">{{ $voters->total() }}</span>
                    {{ Str::plural('voter', $voters->total()) }} found
                </div>
                <div class="results-page-info">
                    Showing {{ $voters->firstItem() }}–{{ $voters->lastItem() }} of {{ $voters->total() }}
                </div>
            </div>

            <div class="results-list">
                @foreach($voters as $voter)
                    <div class="voter-card">
                        <div class="voter-card-left">
                            <div class="voter-serial">{{ $voter->serial_number ?? $voter->id }}</div>
                            <div class="voter-avatar">
                                {{ strtoupper(substr($voter->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="voter-card-body">
                            <h3 class="voter-name">{{ $voter->name }}</h3>
                            <div class="voter-meta">
                                @if($voter->branch)
                                    <span class="voter-branch">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2H4a1 1 0 110-2V4zm3 1h2v2H7V5zm2 4H7v2h2V9zm2-4h2v2h-2V5zm2 4h-2v2h2V9z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $voter->branch }}
                                    </span>
                                @endif
                                @if($voter->registration_number)
                                    <span class="voter-reg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="meta-icon" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" />
                                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" />
                                        </svg>
                                        Reg. No: {{ $voter->registration_number }}
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="voter-card-actions">
                            <a href="{{ route('slip.download', $voter->id) }}" class="btn-slip" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" class="btn-icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Download Slip
                            </a>
                            <a href="{{ route('slip.share', $voter->id) }}" class="btn-share">
                                <svg xmlns="http://www.w3.org/2000/svg" class="btn-icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                                Share
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-wrapper">
                {{ $voters->links('components.pagination') }}
            </div>
        @endif
    @endif
</div>

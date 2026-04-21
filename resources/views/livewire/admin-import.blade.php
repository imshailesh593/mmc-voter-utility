<div style="max-width:600px">
    @if($statusKey)
        <div wire:poll.4000ms="checkStatus" style="display:none"></div>
    @endif
    <div class="card">
        <div class="card-header">
            <span class="card-title">Import Voter Data</span>
            <span style="font-size:0.75rem;color:var(--gray-400)">
                {{ number_format($voterCount) }} voters currently in database
            </span>
        </div>

        <div class="card-body" style="display:flex;flex-direction:column;gap:1rem">

            @if($successMessage)
                <div class="alert alert-success">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $successMessage }}
                </div>
            @endif

            @if($errorMessage)
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $errorMessage }}
                </div>
            @endif

            @if($errors->has('file'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $errors->first('file') }}
                </div>
            @endif

            @if($statusKey)
                <div class="alert alert-info">
                    <svg style="animation:spin 1.2s linear infinite;flex-shrink:0;width:15px;height:15px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Importing in background… voter count updates when done. You can leave this page.
                </div>
            @endif

            <label
                for="file-upload"
                class="upload-zone"
                x-data="{ dragging: false }"
                @dragover.prevent="dragging = true"
                @dragleave.prevent="dragging = false"
                @drop.prevent="dragging = false"
                :class="{ dragging: dragging }"
            >
                @if($file)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span class="upload-zone-file">{{ $file->getClientOriginalName() }}</span>
                    <span class="upload-zone-sub">{{ number_format($file->getSize() / 1024, 1) }} KB — Click to change</span>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <span class="upload-zone-text">Click to upload or drag & drop</span>
                    <span class="upload-zone-sub">.xlsx, .xls, .csv — max 100 MB</span>
                @endif
                <input id="file-upload" type="file" wire:model="file" style="display:none" accept=".xlsx,.xls,.csv">
            </label>

            <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:0.6rem 0.9rem;font-size:0.76rem;color:#92400e">
                <strong>Expected columns:</strong> BranchName, Name, Mobile &nbsp;(Registration Number and Serial Number optional)
            </div>

            <label style="display:flex;align-items:center;gap:0.6rem;font-size:0.83rem;color:var(--gray-600);cursor:pointer">
                <input type="checkbox" wire:model="clearExisting" style="width:15px;height:15px;accent-color:var(--red-600);cursor:pointer">
                Clear all existing voter records before importing
            </label>

            <button
                type="button"
                wire:click="import"
                class="btn btn-primary"
                style="padding:0.7rem 1.25rem;font-size:0.88rem"
                wire:loading.attr="disabled"
                @if(!$file || $statusKey) disabled @endif
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/></svg>
                <span wire:loading.remove wire:target="import">Import Voters</span>
                <span wire:loading wire:target="import">Queuing…</span>
            </button>

        </div>
    </div>
</div>

<style>@keyframes spin { to { transform: rotate(360deg); } }</style>

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

            @if(session('errors') && session('errors')->has('file'))
                <div class="alert alert-error">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('errors')->first('file') }}
                </div>
            @endif

            @if($statusKey)
                <div class="alert alert-info">
                    <svg style="animation:spin 1.2s linear infinite;flex-shrink:0;width:15px;height:15px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Importing in background… voter count updates when done. You can leave this page.
                </div>
            @endif

            @if(!$statusKey)
                <form method="POST" action="{{ route('admin.import.upload') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="upload-zone" id="import-drop-zone" style="margin-bottom:1rem"
                        onclick="document.getElementById('import-file-input').click()"
                        ondragover="event.preventDefault();this.classList.add('dragging')"
                        ondragleave="this.classList.remove('dragging')"
                        ondrop="handleImportDrop(event)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <span class="upload-zone-text" id="import-upload-label">Click to upload or drag & drop</span>
                        <span class="upload-zone-sub">.xlsx, .xls, .csv — max 100 MB</span>
                        <input id="import-file-input" name="file" type="file" accept=".xlsx,.xls,.csv" class="hidden-input"
                            onchange="document.getElementById('import-upload-label').textContent = this.files[0] ? this.files[0].name : 'Click to upload or drag & drop'">
                    </div>

                    @if($errors->has('file'))
                        <div style="font-size:0.75rem;color:var(--red-600);margin-bottom:0.75rem">{{ $errors->first('file') }}</div>
                    @endif

                    <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:0.6rem 0.9rem;font-size:0.76rem;color:#92400e;margin-bottom:1rem">
                        <strong>Expected columns:</strong> Sr. No. &nbsp;·&nbsp; Branch &nbsp;·&nbsp; Name &nbsp;·&nbsp; Reg. No &nbsp;·&nbsp; Final_Roll_No
                    </div>

                    <label style="display:flex;align-items:center;gap:0.6rem;font-size:0.83rem;color:var(--gray-600);cursor:pointer;margin-bottom:1rem">
                        <input type="checkbox" name="clearExisting" value="1" style="width:15px;height:15px;accent-color:var(--red-600);cursor:pointer">
                        Clear all existing voter records before importing
                    </label>

                    <button type="submit" class="btn btn-primary" style="padding:0.7rem 1.25rem;font-size:0.88rem">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"/></svg>
                        Import Voters
                    </button>
                </form>
            @endif

        </div>
    </div>

    <script>
        function handleImportDrop(event) {
            event.preventDefault();
            document.getElementById('import-drop-zone').classList.remove('dragging');
            const file = event.dataTransfer.files[0];
            if (!file) return;
            const input = document.getElementById('import-file-input');
            const dt = new DataTransfer();
            dt.items.add(file);
            input.files = dt.files;
            document.getElementById('import-upload-label').textContent = file.name;
        }
    </script>
</div>

<style>
    .alert-info { display:flex;align-items:center;gap:0.6rem;background:#eff6ff;border:1px solid #bfdbfe;border-radius:8px;padding:0.75rem 1rem;font-size:0.83rem;color:#1e40af; }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

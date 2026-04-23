<div class="card" style="margin-bottom:1.5rem">
    <div class="card-header">
        <span class="card-title">Hero / Banner Image</span>
        <span style="font-size:0.72rem;color:var(--gray-400)">Shown on the public voter portal</span>
    </div>

    <div style="padding:1.25rem;display:flex;gap:1.5rem;flex-wrap:wrap;align-items:flex-start">

        {{-- Current image preview --}}
        <div style="flex-shrink:0;width:260px">
            <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--gray-400);margin-bottom:0.5rem">Current Image</div>
            <img src="{{ $imageUrl }}" alt="Hero Banner"
                style="width:100%;border-radius:8px;border:2px solid var(--gray-200);display:block;">
        </div>

        {{-- Upload form --}}
        <div style="flex:1;min-width:220px;display:flex;flex-direction:column;gap:1rem">

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

            <div>
                <div style="font-size:0.65rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--gray-400);margin-bottom:0.5rem">Upload New Image</div>
                <div class="upload-zone" id="hero-drop-zone"
                    onclick="document.getElementById('hero-file-input').click()"
                    ondragover="event.preventDefault();this.classList.add('dragging')"
                    ondragleave="this.classList.remove('dragging')"
                    ondrop="event.preventDefault();this.classList.remove('dragging')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="upload-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    @if($image)
                        <span class="upload-filename">{{ $image->getClientOriginalName() }}</span>
                        <span class="upload-subtext">{{ round($image->getSize() / 1024) }} KB</span>
                    @else
                        <span class="upload-text">Click or drag image here</span>
                        <span class="upload-subtext">PNG, JPG, WebP · max 10MB</span>
                    @endif
                </div>
                <input id="hero-file-input" type="file" wire:model="image" accept="image/*" class="hidden-input">
                @error('image') <div style="font-size:0.75rem;color:var(--red-600);margin-top:0.35rem">{{ $message }}</div> @enderror
            </div>

            <div style="display:flex;gap:0.5rem;flex-wrap:wrap">
                <button wire:click="upload" class="btn btn-primary-red" wire:loading.attr="disabled" wire:target="upload,image">
                    <span wire:loading.remove wire:target="upload">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:14px;height:14px;display:inline;margin-right:4px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        Upload & Replace
                    </span>
                    <span wire:loading wire:target="upload">Uploading…</span>
                </button>

                @if($hasBackup)
                    <button wire:click="restore" class="btn btn-ghost" wire:loading.attr="disabled" wire:target="restore"
                        onclick="return confirm('Restore the previous image?')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="width:13px;height:13px;display:inline;margin-right:3px"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                        Restore Previous
                    </button>
                @endif
            </div>

        </div>
    </div>

    <style>
        .btn-primary-red {
            display:inline-flex;align-items:center;
            background:var(--red-600);color:#fff;border:none;
            padding:0.5rem 1.1rem;border-radius:7px;
            font-size:0.85rem;font-weight:600;cursor:pointer;
            font-family:inherit;transition:filter 0.15s;
        }
        .btn-primary-red:hover:not(:disabled){filter:brightness(1.08);}
        .btn-primary-red:disabled{opacity:0.6;cursor:not-allowed;}
    </style>
</div>

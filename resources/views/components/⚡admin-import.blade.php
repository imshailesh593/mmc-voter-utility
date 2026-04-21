<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Imports\VotersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Voter;

new class extends Component
{
    use WithFileUploads;

    public $file = null;
    public bool $replaceAll = false;
    public ?string $successMessage = null;
    public ?string $errorMessage = null;

    protected $rules = [
        'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
    ];

    public function import(): void
    {
        $this->validate();
        $this->successMessage = null;
        $this->errorMessage = null;

        try {
            if ($this->replaceAll) {
                Voter::truncate();
            }

            Excel::import(new VotersImport(), $this->file->getRealPath());

            $count = Voter::count();
            $this->successMessage = "Import successful! Total voters in database: {$count}";
            $this->file = null;
            $this->replaceAll = false;
        } catch (\Throwable $e) {
            $this->errorMessage = 'Import failed: ' . $e->getMessage();
        }
    }
};
?>

<div class="admin-import-wrap">
    <div class="admin-card">
        <div class="admin-card-header">
            <svg xmlns="http://www.w3.org/2000/svg" class="admin-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <div>
                <h2>Import Voter Data</h2>
                <p>Upload an Excel or CSV file to populate the voter database.</p>
            </div>
        </div>

        <div class="admin-stats">
            <div class="stat-item">
                <span class="stat-value">{{ App\Models\Voter::count() }}</span>
                <span class="stat-label">Total Voters</span>
            </div>
        </div>

        @if($successMessage)
            <div class="alert-success">
                <svg xmlns="http://www.w3.org/2000/svg" class="alert-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                {{ $successMessage }}
            </div>
        @endif

        @if($errorMessage)
            <div class="alert-error">
                <svg xmlns="http://www.w3.org/2000/svg" class="alert-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                {{ $errorMessage }}
            </div>
        @endif

        <form wire:submit="import" class="import-form">
            <div class="file-upload-area" x-data="{ isDragging: false }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="isDragging = false">
                <label for="file-input" class="file-upload-label" :class="{ 'dragging': isDragging }">
                    <svg xmlns="http://www.w3.org/2000/svg" class="upload-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    @if($file)
                        <p class="upload-filename">{{ $file->getClientOriginalName() }}</p>
                        <p class="upload-size">{{ number_format($file->getSize() / 1024, 1) }} KB</p>
                    @else
                        <p class="upload-text">Click to select or drag & drop</p>
                        <p class="upload-subtext">Excel (.xlsx, .xls) or CSV files — max 10 MB</p>
                    @endif
                    <input id="file-input" type="file" wire:model="file" accept=".xlsx,.xls,.csv" class="hidden-input">
                </label>
                @error('file') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="import-options">
                <label class="checkbox-label">
                    <input type="checkbox" wire:model="replaceAll" class="checkbox-input">
                    <span>Replace all existing data (truncate before import)</span>
                </label>
            </div>

            <div class="format-hint">
                <strong>Expected columns:</strong> name, branch, phone (or mobile), registration_number, serial_number
            </div>

            <button type="submit" class="btn-import" wire:loading.attr="disabled">
                <span wire:loading.remove wire:target="import">
                    <svg xmlns="http://www.w3.org/2000/svg" class="btn-icon-sm" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    Import Voters
                </span>
                <span wire:loading wire:target="import">Importing, please wait...</span>
            </button>
        </form>
    </div>
</div>
<?php

namespace App\Livewire;

use App\Jobs\ImportVotersJob;
use App\Models\Voter;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminImport extends Component
{
    use WithFileUploads;

    public $file = null;
    public bool $clearExisting = false;
    public ?string $statusKey = null;
    public ?string $successMessage = null;
    public ?string $errorMessage = null;
    public int $pollCount = 0;

    public function import(): void
    {
        $this->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:102400',
        ]);

        $this->successMessage = null;
        $this->errorMessage = null;

        $path = $this->file->store('imports', 'local');
        $this->statusKey = 'voter_import_' . uniqid();

        Cache::put($this->statusKey, ['state' => 'queued'], now()->addHour());

        ImportVotersJob::dispatch(
            storage_path('app/private/' . $path),
            $this->clearExisting,
            $this->statusKey,
        );

        $this->file = null;
        $this->clearExisting = false;
    }

    public function checkStatus(): void
    {
        if (! $this->statusKey) {
            return;
        }

        $this->pollCount++;

        // Stop polling after 10 minutes regardless (150 polls × 4s = 600s)
        if ($this->pollCount > 150) {
            $this->statusKey = null;
            $this->pollCount = 0;
            $this->successMessage = 'Import completed. Check voter count above.';
            return;
        }

        $status = Cache::get($this->statusKey);

        // Cache miss means job finished and cache expired, or job failed silently — stop polling
        if (! $status) {
            $this->statusKey = null;
            $this->pollCount = 0;
            $this->successMessage = 'Import completed. Check voter count above.';
            return;
        }

        if ($status['state'] === 'done') {
            $this->successMessage = "Import complete! {$status['count']} voters in the database.";
            $this->statusKey = null;
            $this->pollCount = 0;
        } elseif ($status['state'] === 'error') {
            $this->errorMessage = 'Import failed: ' . $status['message'];
            $this->statusKey = null;
            $this->pollCount = 0;
        }
    }

    public function render()
    {
        return view('livewire.admin-import', [
            'voterCount' => Voter::count(),
        ]);
    }
}

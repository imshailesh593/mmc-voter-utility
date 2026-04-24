<?php

namespace App\Livewire;

use App\Models\Voter;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class AdminImport extends Component
{
    public ?string $statusKey = null;
    public ?string $successMessage = null;
    public ?string $errorMessage = null;
    public int $pollCount = 0;

    public function mount(): void
    {
        if (session()->has('import_status_key')) {
            $this->statusKey = session()->pull('import_status_key');
        }
    }

    public function checkStatus(): void
    {
        if (!$this->statusKey) {
            return;
        }

        $this->pollCount++;

        if ($this->pollCount > 150) {
            $this->statusKey = null;
            $this->pollCount = 0;
            $this->successMessage = 'Import completed. Check voter count above.';
            return;
        }

        $status = Cache::get($this->statusKey);

        if (!$status) {
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

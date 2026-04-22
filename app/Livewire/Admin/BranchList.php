<?php

namespace App\Livewire\Admin;

use App\Imports\BranchVenuesImport;
use App\Models\BranchVenue;
use App\Models\Voter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class BranchList extends Component
{
    use WithFileUploads;

    public string $search = '';
    public ?string $confirmDeleteBranch = null;
    public ?string $successMessage = null;
    public ?string $errorMessage = null;

    public ?string $editingVenueBranch = null;
    public string $editingVenueValue = '';

    public $venueFile = null;
    public bool $showVenueUpload = false;

    public function confirmDelete(string $branch): void
    {
        $this->confirmDeleteBranch = $branch;
    }

    public function cancelDelete(): void
    {
        $this->confirmDeleteBranch = null;
    }

    public function deleteBranch(): void
    {
        if ($this->confirmDeleteBranch) {
            $count = Voter::where('branch', $this->confirmDeleteBranch)->count();
            Voter::where('branch', $this->confirmDeleteBranch)->delete();
            BranchVenue::where('branch', $this->confirmDeleteBranch)->delete();
            $this->successMessage = "{$count} voters from {$this->confirmDeleteBranch} deleted.";
        }
        $this->confirmDeleteBranch = null;
    }

    public function openVenueEdit(string $branch): void
    {
        $this->editingVenueBranch = $branch;
        $this->editingVenueValue = BranchVenue::whereRaw('LOWER(TRIM(branch)) = ?', [strtolower(trim($branch))])->value('venue') ?? '';
    }

    public function cancelVenueEdit(): void
    {
        $this->editingVenueBranch = null;
        $this->editingVenueValue = '';
    }

    public function saveVenue(): void
    {
        if (!$this->editingVenueBranch) return;

        $venue = trim($this->editingVenueValue);

        if ($venue === '') {
            BranchVenue::where('branch', $this->editingVenueBranch)->delete();
        } else {
            BranchVenue::updateOrCreate(
                ['branch' => trim($this->editingVenueBranch)],
                ['venue'  => $venue]
            );
        }

        $this->successMessage = "Venue updated for {$this->editingVenueBranch}.";
        $this->editingVenueBranch = null;
        $this->editingVenueValue = '';
    }

    public function importVenues(): void
    {
        $this->validate(['venueFile' => 'required|file|mimes:xlsx,xls,csv|max:10240']);

        try {
            $import = new BranchVenuesImport();
            Excel::import($import, $this->venueFile->getRealPath());
            $count = $import->getImportedCount();
            $this->successMessage = "{$count} venue" . ($count !== 1 ? 's' : '') . " imported successfully.";
        } catch (\Throwable $e) {
            $this->errorMessage = 'Import failed: ' . $e->getMessage();
        }

        $this->venueFile = null;
        $this->showVenueUpload = false;
    }

    public function render()
    {
        $query = Voter::select('branch', DB::raw('count(*) as total'))
            ->whereNotNull('branch')->where('branch', '!=', '')
            ->groupBy('branch');

        if ($this->search !== '') {
            $query->where('branch', 'like', '%' . $this->search . '%');
        }

        $branches = $query->orderBy('branch')->get();
        $grandTotal = Voter::count();
        $venues = BranchVenue::allKeyed();

        return view('livewire.admin.branch-list', compact('branches', 'grandTotal', 'venues'));
    }
}

<?php

namespace App\Livewire\Admin;

use App\Models\Voter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class BranchList extends Component
{
    public string $search = '';
    public ?string $confirmDeleteBranch = null;
    public ?string $successMessage = null;

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
            $this->successMessage = "{$count} voters from {$this->confirmDeleteBranch} deleted.";
        }
        $this->confirmDeleteBranch = null;
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

        return view('livewire.admin.branch-list', compact('branches', 'grandTotal'));
    }
}

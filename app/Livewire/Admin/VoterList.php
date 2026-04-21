<?php

namespace App\Livewire\Admin;

use App\Models\Voter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class VoterList extends Component
{
    use WithPagination;

    public string $search = '';
    public string $branch = '';
    public ?int $confirmDeleteId = null;
    public ?string $confirmDeleteBranch = null;
    public ?string $successMessage = null;

    public function updatedSearch(): void { $this->resetPage(); }
    public function updatedBranch(): void { $this->resetPage(); }

    public function confirmDelete(int $id): void
    {
        $this->confirmDeleteId = $id;
        $this->confirmDeleteBranch = null;
    }

    public function confirmDeleteBranch(string $branch): void
    {
        $this->confirmDeleteBranch = $branch;
        $this->confirmDeleteId = null;
    }

    public function cancelDelete(): void
    {
        $this->confirmDeleteId = null;
        $this->confirmDeleteBranch = null;
    }

    public function deleteVoter(): void
    {
        if ($this->confirmDeleteId) {
            Voter::destroy($this->confirmDeleteId);
            $this->successMessage = 'Voter deleted.';
        }
        $this->confirmDeleteId = null;
    }

    public function deleteBranch(): void
    {
        if ($this->confirmDeleteBranch) {
            $count = Voter::where('branch', $this->confirmDeleteBranch)->count();
            Voter::where('branch', $this->confirmDeleteBranch)->delete();
            $this->successMessage = "{$count} voters from {$this->confirmDeleteBranch} deleted.";
            $this->branch = '';
        }
        $this->confirmDeleteBranch = null;
        $this->resetPage();
    }

    public function render()
    {
        $query = Voter::query();

        if ($this->search !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->branch !== '') {
            $query->where('branch', $this->branch);
        }

        $voters = $query->orderBy('branch')->orderBy('name')->paginate(25);

        $branches = Voter::select('branch', DB::raw('count(*) as total'))
            ->whereNotNull('branch')->where('branch', '!=', '')
            ->groupBy('branch')->orderBy('branch')
            ->get();

        return view('livewire.admin.voter-list', compact('voters', 'branches'));
    }
}

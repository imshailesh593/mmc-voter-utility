<?php

namespace App\Livewire;

use App\Models\Voter;
use Livewire\Component;
use Livewire\WithPagination;

class VoterMarking extends Component
{
    use WithPagination;

    public string $branch = '';
    public string $search = '';
    public string $filter = 'all'; // all | voted | not_voted

    public function updatedBranch(): void
    {
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedFilter(): void
    {
        $this->resetPage();
    }

    public function toggleVoted(int $id): void
    {
        $voter = Voter::findOrFail($id);
        $voter->voted = !$voter->voted;
        if (!$voter->voted) {
            $voter->in_favour = null;
        }
        $voter->save();
    }

    public function setInFavour(int $id, ?bool $value): void
    {
        Voter::where('id', $id)->update(['in_favour' => $value]);
    }

    public function branches(): array
    {
        return Voter::whereNotNull('branch')
            ->where('branch', '!=', '')
            ->distinct()
            ->orderBy('branch')
            ->pluck('branch')
            ->toArray();
    }

    public function branchStats(): array
    {
        if (!$this->branch) {
            return [];
        }

        $base = Voter::where('branch', $this->branch);

        return [
            'total'      => (clone $base)->count(),
            'voted'      => (clone $base)->where('voted', true)->count(),
            'in_favour'  => (clone $base)->where('in_favour', true)->count(),
            'against'    => (clone $base)->where('in_favour', false)->count(),
        ];
    }

    public function render()
    {
        $voters = null;

        if ($this->branch) {
            $query = Voter::where('branch', $this->branch);

            if ($this->search !== '') {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('registration_number', 'like', '%' . $this->search . '%');
                });
            }

            if ($this->filter === 'voted') {
                $query->where('voted', true);
            } elseif ($this->filter === 'not_voted') {
                $query->where('voted', false);
            }

            $voters = $query->orderBy('name')->paginate(50);
        }

        return view('livewire.voter-marking', [
            'voters'      => $voters,
            'branches'    => $this->branches(),
            'stats'       => $this->branchStats(),
        ]);
    }
}

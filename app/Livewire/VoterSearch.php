<?php

namespace App\Livewire;

use App\Models\BranchVenue;
use App\Models\Voter;
use Livewire\Component;
use Livewire\WithPagination;

class VoterSearch extends Component
{
    use WithPagination;

    public string $phone = '';
    public string $name = '';
    public string $registration = '';
    public bool $searched = false;

    public function search(): void
    {
        $this->resetPage();
        $this->searched = true;
    }

    public function clear(): void
    {
        $this->reset(['phone', 'name', 'registration', 'searched']);
        $this->resetPage();
    }

    public function render()
    {
        $voters = null;

        if ($this->searched && ($this->phone !== '' || $this->name !== '' || $this->registration !== '')) {
            $voters = Voter::search($this->phone, $this->name, $this->registration)->paginate(15);
        }

        $venues = BranchVenue::allKeyed();

        return view('livewire.voter-search', ['voters' => $voters, 'venues' => $venues]);
    }
}

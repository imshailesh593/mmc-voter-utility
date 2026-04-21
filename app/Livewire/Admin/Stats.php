<?php

namespace App\Livewire\Admin;

use App\Models\Voter;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Stats extends Component
{
    public function render()
    {
        $total = Voter::count();
        $branches = Voter::distinct('branch')->whereNotNull('branch')->where('branch', '!=', '')->count('branch');
        $withPhone = Voter::whereNotNull('phone')->count();
        $noPhone = $total - $withPhone;

        $topBranches = Voter::select('branch', DB::raw('count(*) as total'))
            ->whereNotNull('branch')->where('branch', '!=', '')
            ->groupBy('branch')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('livewire.admin.stats', compact('total', 'branches', 'withPhone', 'noPhone', 'topBranches'));
    }
}

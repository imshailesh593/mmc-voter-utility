<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class HeroImage extends Component
{
    public function render()
    {
        $dest = public_path('images/candidate-badge.png');
        return view('livewire.admin.hero-image', [
            'hasBackup' => file_exists(public_path('images/candidate-badge.backup.png')),
            'imageUrl'  => '/images/candidate-badge.png?v=' . (file_exists($dest) ? filemtime($dest) : 0),
        ]);
    }
}

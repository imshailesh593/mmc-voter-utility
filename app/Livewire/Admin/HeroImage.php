<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;

class HeroImage extends Component
{
    use WithFileUploads;

    public $image = null;
    public ?string $successMessage = null;
    public ?string $errorMessage = null;

    public function upload(): void
    {
        $this->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);

        try {
            $destination = public_path('images/candidate-badge.png');

            if (file_exists($destination)) {
                copy($destination, public_path('images/candidate-badge.backup.png'));
            }

            $ext = strtolower($this->image->getClientOriginalExtension());

            if ($ext === 'png') {
                $this->image->move(public_path('images'), 'candidate-badge.png');
            } else {
                // Convert to PNG via GD
                $tmpPath = $this->image->getRealPath();
                $img = match($ext) {
                    'jpg', 'jpeg' => imagecreatefromjpeg($tmpPath),
                    'webp'        => imagecreatefromwebp($tmpPath),
                    default       => null,
                };
                if ($img) {
                    imagepng($img, $destination);
                    imagedestroy($img);
                } else {
                    $this->image->move(public_path('images'), 'candidate-badge.png');
                }
            }

            $this->successMessage = 'Hero image updated successfully.';
            $this->errorMessage = null;
        } catch (\Throwable $e) {
            $this->errorMessage = 'Upload failed: ' . $e->getMessage();
        }

        $this->image = null;
    }

    public function restore(): void
    {
        $backup = public_path('images/candidate-badge.backup.png');

        if (!file_exists($backup)) {
            $this->errorMessage = 'No backup image found.';
            return;
        }

        copy($backup, public_path('images/candidate-badge.png'));
        $this->successMessage = 'Previous image restored.';
        $this->errorMessage = null;
    }

    public function render()
    {
        return view('livewire.admin.hero-image', [
            'hasBackup' => file_exists(public_path('images/candidate-badge.backup.png')),
            'imageUrl'  => '/images/candidate-badge.png?v=' . (file_exists(public_path('images/candidate-badge.png')) ? filemtime(public_path('images/candidate-badge.png')) : 0),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HeroImageController extends Controller
{
    private string $destination;
    private string $backup;

    public function __construct()
    {
        $this->destination = public_path('images/candidate-badge.png');
        $this->backup      = public_path('images/candidate-badge.backup.png');
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg,webp|max:10240',
        ]);

        try {
            if (!is_dir(public_path('images'))) {
                mkdir(public_path('images'), 0755, true);
            }

            if (file_exists($this->destination)) {
                copy($this->destination, $this->backup);
            }

            $ext = strtolower($request->file('image')->getClientOriginalExtension());

            if ($ext === 'png') {
                $request->file('image')->move(public_path('images'), 'candidate-badge.png');
            } else {
                $tmpPath = $request->file('image')->getRealPath();
                $img = match ($ext) {
                    'jpg', 'jpeg' => imagecreatefromjpeg($tmpPath),
                    'webp'        => imagecreatefromwebp($tmpPath),
                    default       => null,
                };
                if ($img) {
                    imagepng($img, $this->destination);
                    imagedestroy($img);
                } else {
                    $request->file('image')->move(public_path('images'), 'candidate-badge.png');
                }
            }

            return back()->with('hero_success', 'Hero image updated successfully.');
        } catch (\Throwable $e) {
            return back()->with('hero_error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function restore()
    {
        if (!file_exists($this->backup)) {
            return back()->with('hero_error', 'No backup image found.');
        }

        copy($this->backup, $this->destination);
        return back()->with('hero_success', 'Previous image restored.');
    }
}

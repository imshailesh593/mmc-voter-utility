<?php

namespace App\Http\Controllers;

use App\Models\BranchVenue;
use App\Models\Voter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SlipController extends Controller
{
    private const DEFAULT_VENUE = 'District Headquarter';

    public function download(int $id): Response
    {
        $voter = Voter::findOrFail($id);
        $venue = BranchVenue::forBranch($voter->branch) ?? self::DEFAULT_VENUE;

        $pdf = Pdf::loadView('slip.voter-slip', ['voter' => $voter, 'venue' => $venue])
            ->setPaper([0, 0, 595, 340], 'portrait');

        $filename = 'voting-slip-' . str($voter->name)->slug() . '.pdf';

        return $pdf->download($filename);
    }

    public function share(int $id)
    {
        $voter = Voter::findOrFail($id);
        $venue = BranchVenue::forBranch($voter->branch) ?? self::DEFAULT_VENUE;
        return view('slip.share', ['voter' => $voter, 'venue' => $venue]);
    }
}

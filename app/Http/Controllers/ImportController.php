<?php

namespace App\Http\Controllers;

use App\Jobs\ImportVotersJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ImportController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:102400',
        ]);

        $path = $request->file('file')->store('imports', 'local');
        $statusKey = 'voter_import_' . uniqid();

        Cache::put($statusKey, ['state' => 'queued'], now()->addHour());

        ImportVotersJob::dispatch(
            storage_path('app/private/' . $path),
            $request->boolean('clearExisting'),
            $statusKey,
        );

        return redirect()->route('admin.import')->with('import_status_key', $statusKey);
    }
}

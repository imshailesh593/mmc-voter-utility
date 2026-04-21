<?php

namespace App\Jobs;

use App\Imports\VotersImport;
use App\Models\Voter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Cache;
use Maatwebsite\Excel\Facades\Excel;

class ImportVotersJob implements ShouldQueue
{
    use Queueable;

    public int $timeout = 0;
    public int $tries = 1;

    public function __construct(
        private readonly string $filePath,
        private readonly bool $clearExisting,
        private readonly string $statusKey,
    ) {}

    public function handle(): void
    {
        Cache::put($this->statusKey, ['state' => 'running'], now()->addHour());

        try {
            if ($this->clearExisting) {
                Voter::truncate();
            }

            Excel::import(new VotersImport(), $this->filePath);

            Cache::put($this->statusKey, [
                'state' => 'done',
                'count' => Voter::count(),
            ], now()->addHour());
        } catch (\Throwable $e) {
            Cache::put($this->statusKey, [
                'state' => 'error',
                'message' => $e->getMessage(),
            ], now()->addHour());
        }
    }
}

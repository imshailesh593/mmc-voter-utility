<?php

namespace App\Imports;

use App\Models\BranchVenue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class BranchVenuesImport implements ToModel, WithHeadingRow, WithUpserts, SkipsEmptyRows
{
    private int $importedCount = 0;

    public function model(array $row): ?BranchVenue
    {
        $branch = trim($row['branch'] ?? '');
        $venue  = trim($row['location_of_polling_station'] ?? $row['venue'] ?? $row['location'] ?? '');

        if (empty($branch) || empty($venue)) {
            return null;
        }

        $this->importedCount++;

        return new BranchVenue([
            'branch' => $branch,
            'venue'  => $venue,
        ]);
    }

    public function uniqueBy(): string|array
    {
        return ['branch'];
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }
}

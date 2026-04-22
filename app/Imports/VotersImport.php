<?php

namespace App\Imports;

use App\Models\Voter;
use Maatwebsite\Excel\Concerns\ToUpsertModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;

class VotersImport implements ToUpsertModel, WithHeadingRow, WithBatchInserts, WithChunkReading, SkipsEmptyRows
{
    private int $importedCount = 0;

    public function model(array $row): ?Voter
    {
        $name = trim($row['name'] ?? $row['voter_name'] ?? $row['full_name'] ?? '');
        if (empty($name)) {
            return null;
        }

        $phone = preg_replace('/\D/', '', trim($row['phone'] ?? $row['mobile'] ?? $row['mobile_number'] ?? $row['phone_number'] ?? ''));
        if (strlen($phone) > 15) {
            $phone = substr($phone, -10);
        }

        $this->importedCount++;

        return new Voter([
            'name'                => $name,
            'branch'              => trim($row['branch'] ?? $row['branch_name'] ?? $row['branchname'] ?? ''),
            'phone'               => $phone ?: null,
            'registration_number' => trim($row['registration_number'] ?? $row['registration'] ?? $row['reg_no'] ?? '') ?: null,
            'serial_number'       => trim($row['serial_number'] ?? $row['serial'] ?? $row['sr_no'] ?? '') ?: null,
            'electoral_number'    => trim($row['electoral_number'] ?? $row['electoral'] ?? $row['electoralnumber'] ?? $row['electoral_no'] ?? '') ?: null,
            'degree'              => trim($row['degree'] ?? $row['qualification'] ?? '') ?: null,
            'address'             => trim($row['address'] ?? $row['area'] ?? '') ?: null,
        ]);
    }

    public function uniqueBy(): string|array
    {
        return ['registration_number'];
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }
}

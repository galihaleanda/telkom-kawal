<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Datel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class DatelImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    use SkipsErrors;

    private int $imported = 0;
    private int $skipped  = 0;

    /**
     * Kolom Excel: "DATEL", "BRANCH"
     */
    public function model(array $row): ?Datel
    {
        $name       = trim($row['datel']  ?? '');
        $branchName = trim($row['branch'] ?? '');

        if (empty($name) || empty($branchName)) {
            $this->skipped++;
            return null;
        }

        $branch = Branch::whereRaw('LOWER(name) = ?', [strtolower($branchName)])->first();
        if (!$branch) {
            $this->skipped++;
            return null;
        }

        // Skip duplikat
        $exists = Datel::whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->where('branch_id', $branch->id)
            ->exists();

        if ($exists) {
            $this->skipped++;
            return null;
        }

        $this->imported++;
        return new Datel([
            'name'      => $name,
            'branch_id' => $branch->id,
        ]);
    }

    public function getImported(): int { return $this->imported; }
    public function getSkipped(): int  { return $this->skipped; }
}

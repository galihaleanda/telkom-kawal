<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\Witel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class BranchImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    use SkipsErrors;

    private int $imported = 0;
    private int $skipped  = 0;

    /**
     * Kolom Excel: "BRANCH", "Witel"
     */
    public function model(array $row): ?Branch
    {
        $name      = trim($row['branch'] ?? '');
        $witelName = trim($row['witel']  ?? '');

        if (empty($name) || empty($witelName)) {
            $this->skipped++;
            return null;
        }

        $witel = Witel::whereRaw('LOWER(name) = ?', [strtolower($witelName)])->first();
        if (!$witel) {
            $this->skipped++;
            return null;
        }

        // Skip duplikat
        $exists = Branch::whereRaw('LOWER(name) = ?', [strtolower($name)])
            ->where('witel_id', $witel->id)
            ->exists();

        if ($exists) {
            $this->skipped++;
            return null;
        }

        $this->imported++;
        return new Branch([
            'name'     => $name,
            'witel_id' => $witel->id,
        ]);
    }

    public function getImported(): int { return $this->imported; }
    public function getSkipped(): int  { return $this->skipped; }
}

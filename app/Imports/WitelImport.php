<?php

namespace App\Imports;

use App\Models\Witel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class WitelImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    use SkipsErrors;

    private int $imported = 0;
    private int $skipped  = 0;

    /**
     * Heading row key: "witel" (kolom "Witel" pada Excel)
     */
    public function model(array $row): ?Witel
    {
        $name = trim($row['witel'] ?? '');

        if (empty($name)) {
            $this->skipped++;
            return null;
        }

        // Skip duplikat
        $exists = Witel::whereRaw('LOWER(name) = ?', [strtolower($name)])->exists();
        if ($exists) {
            $this->skipped++;
            return null;
        }

        $this->imported++;
        return new Witel(['name' => $name]);
    }

    public function getImported(): int { return $this->imported; }
    public function getSkipped(): int  { return $this->skipped; }
}

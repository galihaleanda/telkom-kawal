<?php

namespace App\Imports;

use App\Models\Sektor;
use App\Models\Sto;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class StoImport implements ToModel, WithHeadingRow, SkipsEmptyRows, SkipsOnError
{
    use SkipsErrors;

    private int $imported = 0;
    private int $skipped  = 0;

    /**
     * Kolom Excel: "STO" (code), "STO Full" (name), "SEKTOR"
     * Heading key: "sto", "sto_full", "sektor"
     */
    public function model(array $row): ?Sto
    {
        $code       = trim($row['sto']      ?? '');
        $name       = trim($row['sto_full'] ?? '');
        $sektorName = trim($row['sektor']   ?? '');

        if (empty($code) || empty($sektorName)) {
            $this->skipped++;
            return null;
        }

        $sektor = Sektor::whereRaw('LOWER(name) = ?', [strtolower($sektorName)])->first();
        if (!$sektor) {
            $this->skipped++;
            return null;
        }

        // Skip duplikat berdasarkan code STO (unique)
        $exists = Sto::whereRaw('LOWER(code) = ?', [strtolower($code)])->exists();
        if ($exists) {
            $this->skipped++;
            return null;
        }

        $this->imported++;
        return new Sto([
            'code'      => $code,
            'name'      => $name ?: null,
            'sektor_id' => $sektor->id,
        ]);
    }

    public function getImported(): int { return $this->imported; }
    public function getSkipped(): int  { return $this->skipped; }
}
